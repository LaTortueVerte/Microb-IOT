#include "DHT.h"        // librairie du capteur de température DHT
#include <MQUnifiedsensor.h> //librairie liée au capteur MQ9
#include "Servo.h" //librairie liée au servomoteur
#include "LiquidCrystal_I2C.h" // librairie de l'afficheur LCD avec une connexion par le protocole I2C

LiquidCrystal_I2C lcd(0x27,16,2); //définition du nombre de lignes et de colonnes présents dans l'afficheur LCD ainsi que de l'adresse mémoire de celui-ci

#define RatioMQ9CleanAir (9.6) //RS / R0 = 60 ppm (formule nécessaire au bon fonctionnement du MQ9)
#define DHTPIN A4       // detection de la température et de l'humidité
#define ldrPin A3       // detection de la luminosité
#define motorWaterPin 2 // actionneur moteur qui représente
#define motorDCPin 3    // actionneur moteur qui représente le ventilateur
#define DegEauxInPIN 4  // détecteur du niveau de l'eau dans le local
#define servmotorPIN 5  // actionneur moteur pour simuler l'ouverture/fermeture de la fenetre
#define IncendiePIN 6   // actionneur LED Rouge activation d'un sytème qui éteint l'incendie
#define LEDAQ 9         // led alerte mauvaise qualité d'air
#define LEDY 10         // led alerte degat des eaux --> coupure électricité des prises de la pièce
#define LEDR 11         // led alerte incendit
#define tempExtPIN A5   // detetion de la température extérieure

#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

//Données relatives au capteur MQ9
MQUnifiedsensor MQ9("Arduino MEGA", 5, 10, A2, "MQ-9"); // Board, Voltage_resolution, ADC_Bit_Resolution, Pin, Type
float tab[3]; //récupération des valeurs mesurées par le capteur MQ9 (valeur du GPL, valeur du CH4, valeur du CO)
bool alertMQ9[3] = {0}; //détection de la dangerosité des différents gaz mesurés par le MQ9

//Données relatives au capteur HCHO
// Source : http://www.himix.lt/arduino/arduino-and-hcho-benzene-toluene-alcohol-sensor/
float Vol, ppm;
int sensorValue;
bool formaldehydeDetect;

Servo monServomoteur;

int ecran = 0; //affichage des données issues des capteurs alternativement, les données à afficher dépendent de la valeur d'ecran 

int changeEcran = 999; // compteur qui permet d'afficher les données successivement pendant un temps donné et de les changer lorsque le temps est écoulé

// UART variables

boolean window_state = false;
int ventilation_power = 0;
double min_temp_ventilation = 18.00;
double max_temp_ventilation = 24.00;
boolean pump_state = false;        // la pompe est allumée
boolean air_quality_module = true; // si le module de qualité d'air existe
boolean water_module = true;
boolean gas_module_alert = true;

// Variables
int readLevel;

float reading;
float tempout;
float humidity;
float tempin;

boolean polluted = false;   // le local est pollué par des gaz
boolean hotTemp = false;    // il fait trop chaud dans le loc
boolean goodTemp = true;    // il fait bon
boolean coldTemp = false;   // il fait froid
boolean difpositive = true; // il fait plus chaud dehors que dedans
boolean ventOn = false;     // le ventilateur est allumé
boolean windowOpen = false; // la fenêtre est ouverte
boolean doorLocked = false; // la porte est vérouillée
boolean alerteUser = false; // une alerte est envoyé à l'utilisateur
boolean isHumid = false;    // le seuil d'humidité est atteint
// boolean flashLED = false;


// -----------------------------------------------------------------------------------
// SETUP AND LOOP
// -----------------------------------------------------------------------------------


void setup()
{
  Serial.begin(9600);
  dht.begin();
  
  //définition des pins (entrées/sorties)
  pinMode(DHTPIN, INPUT);
  pinMode(ldrPin, INPUT);
  pinMode(motorWaterPin, OUTPUT);
  pinMode(motorDCPin, OUTPUT);
  pinMode(DegEauxInPIN, INPUT);
  pinMode(servmotorPIN, OUTPUT);
  pinMode(IncendiePIN, OUTPUT);
  pinMode(LEDAQ, OUTPUT);
  pinMode(LEDY, OUTPUT);
  pinMode(LEDR, OUTPUT);
  pinMode(tempExtPIN, INPUT);

  
  int error = MQ9Setup();

  //instanciation d'un objet Servo pour agir sur le servomoteur
  monServomoteur.attach(servmotorPIN);

  //paramétrages nécessaires au bon fonctionnement de l'écran LCD
  lcd.init();
  lcd.backlight();
}

void loop()
{

  // récupère la donnée du capteur de température extérieur
  reading = analogRead(tempExtPIN);
  //tempout = get_temp_out(reading);
  tempout = 20; //température ambiante

  // recupère les infos du DHT11 pour la température et l'humidité
  humidity = dht.readHumidity();
  tempin = dht.readTemperature();


  difpositive = is_temp_positive(tempin, tempout);

  //prévention des potentiels dangers en fonction des valeurs mesurées par les capteurs
  set_temp_flags(tempin, &hotTemp, &goodTemp, &coldTemp);

  //récupère les mesures des gaz détectés par le MQ9 
  MQ9mesure(tab);

  //Activation du système de détection dans le MQ9
  MQ9valeurseuil(tab, alertMQ9, lcd);
 

  //récupère les mesures des gaz détectés par le HCHO
  sensorValue=analogRead(A6);
  Vol=sensorValue*4.95/1023;
  ppm = map(Vol, 0, 4.95, 1, 50); // Concentration Range: 1~50 ppm 
  

   //Activation du système de détection dans le HCHO
   HCHOAlertDetection(sensorValue, &formaldehydeDetect,lcd);


  //Si l'un des capteurs détecte une quantité anormale de gaz --> le local est pollué il faut aérer !   
  if (alertMQ9[0] == 1 || alertMQ9[1] == 1 || alertMQ9[2] == 1 || formaldehydeDetect == 1){
    polluted = true;
  }
  else
  {
    polluted = false;
  }

  // Module qualité d'air

  // si taux monoxide ou propane ou méthane, alerte utilisateur, ventilation + fenètre ouverte
  if (polluted) // regarder quand l'air est polluer sur le MQ9
  {
    if (!windowOpen)
    {
      // window opens
      open_window(monServomoteur, &windowOpen);
    }
    if (!ventOn)
    {
      // ventilo switch on
      switch_vent_on(tempout, &ventOn, min_temp_ventilation, max_temp_ventilation);
    }
    if (gas_module_alert)
    {
      // alerter l'utilisateur
      alerte_user(&alerteUser);
    }
  }
  else if (!air_quality_module)
  {
    analogWrite(motorDCPin, ventilation_power * 2.55);
    if (window_state)
    {
      monServomoteur.write(90);
    }
    else
    {
      monServomoteur.write(0);
    }
  }
  else
  {
    // si la température est trop élevée à l'intérieur
    if (hotTemp)
    {
      // allumer la ventilation si elle ne l'est pas déjà
      if (!ventOn)
      {
        // ventilo switched on
        // ventOn = true;
        // +ventilo à 100%
        switch_vent_on(tempout, &ventOn, min_temp_ventilation, max_temp_ventilation);
      }
      if (difpositive)
      { // s'il fait moins chaud dehors
        if (!windowOpen)
        {
          // window opens
          open_window(monServomoteur, &windowOpen);
        }
      }
      else if (!difpositive)
      { // s'il fait plus chaud dehors
        if (windowOpen)
        {
          // window closes
          close_window(&windowOpen);
        }
      }
    }
    // else if température faible à l'intérieur
    if (coldTemp)
    {
      // éteindre la ventilation si elle ne l'est pas déjà
      if (ventOn)
      {
        // ventilo switched off
        switch_vent_off(&ventOn);
      }
      if (difpositive)
      { // s'il fait moins chaud dehors
        if (windowOpen)
        {
          // window closes
          close_window(&windowOpen);
        }
      }
      else if (!difpositive)
      {
        if (!windowOpen)
        {
          // window opens
          open_window(monServomoteur, &windowOpen);
        }
      }
    }
  
    if (humidity > 80)
    {
      isHumid = true;
      open_window(monServomoteur, &windowOpen);
    }
  
    // else il fait bon et l'air est pur
    else
    {
      if (!ventOn)
      {
        // ventilo switch on
        switch_vent_on(tempin, &ventOn, min_temp_ventilation, max_temp_ventilation);
      }
    }
  }

  if (water_module)
  {
    // Partie dégâts des eaux - source : https://www.instructables.com/Water-Level-Alarm-Using-Arduino/
  
    readLevel = digitalRead(DegEauxInPIN); //DegEauxInPIN et LEDY agissent ensemble comme un interrupteur
    if (readLevel == LOW) //Le circuit est fermé
    {
      digitalWrite(LEDY, HIGH);
      analogWrite(motorWaterPin, 255); // activation de la pompe au maximum
    }
    else
    {
      digitalWrite(LEDY, LOW);
      analogWrite(motorWaterPin, 0); // désactivation de la pompe
    }
  }
  else
  {
    if (pump_state) //Le circuit est fermé
    {
      digitalWrite(LEDY, HIGH);
      analogWrite(motorWaterPin, 255); // activation de la pompe au maximum
    }
    else
    {
      digitalWrite(LEDY, LOW);
      analogWrite(motorWaterPin , 0); // désactivation de la pompe
    }
  }
  
  //Affichage alternatif sur l'afficheur LCD
  changeEcran ++;
  if (changeEcran > 100){
    ecran++;
    changeEcran = 0;
    AffichEcran(lcd, ecran, tab, tempin, humidity, sensorValue);
    if (ecran == 3){
      ecran = 0;
    }
  }

  // UART COMMUNICATION

  communicationData();
}

// -----------------------------------------------------------------------------------
//  FUNCTIONS
// -----------------------------------------------------------------------------------

// UART ------------------------------------------------------------------------------

void readSerialPort(int *var_id, int *var_content) {
    String msg = "";
    if (Serial.available()) {
        delay(10);
        while (Serial.available() > 0) {
            msg += (char)Serial.read();
        }
        Serial.flush();
    }

    int sep_index = msg.indexOf('=');
    *var_id = msg.substring(0, sep_index).toInt();
    *var_content = msg.substring(sep_index + 1, sizeof(msg) - 1).toInt();
}

void sendData() {

    String msg =   String(tab[0]) + "|" + 
            String(tab[1]) + "|" + 
            String(tab[2]) + "|" + 
            String(polluted) + "|" + 
            String(readLevel) + "|" + 
            String(formaldehydeDetect) + "|" + 
            String(tempin) + "|" + 
            String(humidity) + "|" +

            String(gas_module_alert) + "|" +
            String(water_module) + "|" +
            String(pump_state) + "|" +
            String(air_quality_module) + "|" +
            String(ventilation_power) + "|" +
            String(window_state) + "|" +
            String(min_temp_ventilation) + "|" +
            String(max_temp_ventilation);
            
    Serial.print(msg);
}

void communicationData(){

    // Ecoute UART

    int var_id = 0;
    int var_content = 0;

    readSerialPort(&var_id, &var_content);

    // Update variables

    switch (var_id){
        case 2: // gas_module_alert
            gas_module_alert = var_content;
        break;
        case 3: // water_module
            water_module = var_content;
        break;
        case 4: // pump_state
            pump_state = var_content;
        break;
        case 5: // air_quality
            air_quality_module = var_content;
        break;
        case 6: // ventilation_power
            ventilation_power = var_content;
        break;
        case 7: // window_state
            window_state = var_content;
        break;
        case 8: // min_temp_ventilation
            min_temp_ventilation = var_content;
        break;
        case 9: // max_temp_ventilation
            max_temp_ventilation = var_content;
        break;
        default: break;    
    }

    // Send sensor values

    if (var_id != 0)
        sendData();
}

// SENSORS AND ACTUATORS -------------------------------------------------------------

//activation de la ventilation --> excès de gaz ou température trop élevée
void switch_vent_on(float tempin, boolean *ventOn, double max_temp_ventilation, double min_temp_ventilation)
{
  double temp_gap = max_temp_ventilation - min_temp_ventilation;
  float Ftemp = 255 / temp_gap * (tempin - min_temp_ventilation);
  int Pw = min(255, max(0, Ftemp));
  *ventOn = true;
  analogWrite(motorDCPin, Pw);
}
//désactivation de la ventilation 
void switch_vent_off(boolean *ventOn)
{
  analogWrite(motorDCPin, 0);
  *ventOn = false;
}
//ouverture des fenêtres symbolisée par le sevomoteur --> température trop élevée ou excès de gaz
void open_window(Servo monservomoteur, boolean *windowOpen)
{
  int angle = 0;
  monServomoteur.write(180);
  *windowOpen = true;
}
//fermeture des fenêtres --> pas de mouvement du servomoteur
void close_window(boolean *windowOpen)
{
  monServomoteur.write(0);
  *windowOpen = false;
}

//les deux fonctions suivantes alertent directement l'utilisateur à distance en cas de problème
void alerte_user(boolean *alerteUser)
{
  // rajouter un envoie de message à la rasPi jusqu'à l'utilisateur
  digitalWrite(LEDAQ, HIGH);
  *alerteUser = true;
}
void finish_user_alerte(boolean *alerteUser)
{
  digitalWrite(LEDAQ, LOW);
  *alerteUser = false;
}

boolean is_temp_positive(float tempin, float tempout)
{
  float diftemp = tempin - tempout;
  return (0 < diftemp);
}

float get_temp_out(float reading)
{
  float voltage = reading * (5000 / 1024.0);
  float tempout = (voltage - 500) / 10;
  return tempout;
}
//définit les seuils de température et donc les potentiels risques pour le local
void set_temp_flags(float tempin, boolean *hotTemp, boolean *goodTemp, boolean *coldTemp)
{
  if (tempin > 24)
  {
    *hotTemp = true;
    *goodTemp = false;
    *coldTemp = false;
  }
  else if (tempin < 18)
  {
    *hotTemp = false;
    *goodTemp = false;
    *coldTemp = true;
  }
  else
  {
    *hotTemp = false;
    *goodTemp = true;
    *coldTemp = false;
  }
}

int MQ9Setup(){
  MQ9.setRegressionMethod(1); //_PPM =  a*ratio^b
  MQ9.init(); 
  float calcR0 = 0;
  for(int i = 1; i<=10; i ++)
  {
    MQ9.update(); // Update data, the arduino will read the voltage from the analog pin
    calcR0 += MQ9.calibrate(RatioMQ9CleanAir);
  }
  MQ9.setR0(calcR0/10);
  
  int error = 0;
  if(isinf(calcR0)) {
    //Serial.println("Warning: Conection issue, R0 is infinite (Open circuit detected)");
    error = -1;
  }
  if(calcR0 == 0){
    //Serial.println("Warning: Conection issue found, R0 is zero (Analog pin shorts to ground)");
    error = -2;
  }

  return error;
}

void MQ9mesure(float* tab){

  MQ9.update();
  
  MQ9.setA(1000.5); MQ9.setB(-2.186); // Configure the equation to to calculate LPG concentration
  tab[0] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  MQ9.setA(4269.6); MQ9.setB(-2.648); // Configure the equation to to calculate CH4 concentration
  tab[1] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup

  MQ9.setA(599.65); MQ9.setB(-2.244); // Configure the equation to to calculate CO concentration
  tab[2] = MQ9.readSensor(); // Sensor will read PPM concentration using the model, a and b values set previously or from the setup
}

//détection et alerte des dangers en fonction de valeurs seuils mesurées par le capteur MQ9
bool* MQ9valeurseuil(float* tab, bool* reactiontab, LiquidCrystal_I2C lcd){
  if (tab[0] > 500){// Source : http://umpir.ump.edu.my/id/eprint/8365/1/Design_and_Development_of_Gas_Leakage_Monitoring_System.pdf
    reactiontab[0] = 1;
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("ALERT GPL !");
    lcd.setCursor(1,1);
    lcd.print("fuite de gaz");
  }
  if (tab[1] > 9990){// Source : https://www.heatingandprocess.com/methane-gas-detection/ LEL=5% -> 50000 ppm. Comme le module détecte max 10000 alors on met un peu moins -> 9990 ppm
    reactiontab[1] = 1;
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("ALERT CH4 !");
    lcd.setCursor(1,1);
    lcd.print("incendie");
  }
  if (tab[2] > 35){// Source : https://cdn.shopify.com/s/files/1/0406/7681/files/Carbon-Monoxide-Levels-Chart.jpg?v=1565211200
    reactiontab[2] = 1;
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("ALERT CO !");
    lcd.setCursor(1,1);
    lcd.print("suffocation");
  }
  return reactiontab;

}

//détection et alerte des dangers en fonction de valeurs seuils mesurées par le capteur HCHO
void HCHOAlertDetection (int sensorValue, bool* formaldehydeDetect, LiquidCrystal_I2C lcd){
  if (sensorValue > 500) {
      lcd.clear();
      lcd.print("Alert HCHO");
      *formaldehydeDetect = true;
    }
    else {
      *formaldehydeDetect = false;
    }
}

//affichage sur l'écran LCD
void AffichEcran(LiquidCrystal_I2C lcd, int ecran, float* tab, int tempin, float humidity, float sensorValue){
  
  if(ecran == 3){
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("GPL : ");
    lcd.print(tab[0]);
    lcd.print(" ppm");

    lcd.setCursor(0,1);
    lcd.print("CH4 : ");
    lcd.print(tab[1]);
    lcd.print(" ppm");
  }

  else if (ecran == 1){
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("CO : ");
    lcd.print(tab[2]);
    lcd.print(" ppm");

    lcd.setCursor(0,1);
    lcd.print("Temp : ");
    lcd.print(tempin);
    lcd.print(" C");
    
  }
  else if (ecran == 2){
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("humidite : ");
    lcd.print(humidity);
    lcd.print(" %");

    lcd.setCursor(0,1);
    lcd.print("HCHO : ");
    lcd.print(sensorValue);
    lcd.print(" ppm");
  }

  
}
