#include "DHT.h"
#define DHTPIN A4       // detection de la température et de l'humidité
#define ldrPin A3       // detection de la luminosité
#define motorWaterPin 2 // actionneur moteur qui représente
#define motorDCPin 3    // actionneur moteur qui représente le ventilateur
#define DegEauxInPIN 4  // détecteur du niveau de l'eau dans le local
#define servmotorPIN 5  // actionneur moteur pour simuler l'ouverture/fermeture de la fenetre
#define IncendiePIN 6   // actionneur LED Rouge activation d'un sytème qui éteint l'incendie
#define mq9DOutPIN 8    // detection pin de sortie numérique du MQ9 pour les gaz
#define mq9AOutPIN A2   // detection pin de sortie analogique du MQ9 pour les gaz
#define LEDAQ 9         // led alerte mauvaise qualité d'air
#define LEDY 10         // led alerte degat des eaux --> coupure électricité des prises de la pièce
#define LEDR 11         // led alerte incendit
#define tempExtPIN A5   // detetion de la température extérieure

#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

//monServomoteur.attach(servmotorPIN);

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
boolean windowOpen = false; // la fenètre est ouverte
boolean doorLocked = false; // la porte est vérouillée
boolean alerteUser = false; // une alerte est envoyé à l'utilisateur
boolean isHumid = false;    // le seuil d'humidité est atteint
// boolean flashLED = false;

void setup()
{
  Serial.begin(9600);
  dht.begin();
  pinMode(DHTPIN, INPUT);
  pinMode(ldrPin, INPUT);
  pinMode(motorWaterPin, OUTPUT);
  pinMode(motorDCPin, OUTPUT);
  pinMode(DegEauxInPIN, INPUT);
  pinMode(servmotorPIN, OUTPUT);
  pinMode(IncendiePIN, OUTPUT);
  pinMode(mq9DOutPIN, OUTPUT);
  pinMode(mq9AOutPIN, OUTPUT);
  pinMode(LEDAQ, OUTPUT);
  pinMode(LEDY, OUTPUT);
  pinMode(LEDR, OUTPUT);
  pinMode(tempExtPIN, INPUT);
}

void loop()
{

  // récupère la donnée du capteur de température extérieur
  reading = analogRead(tempExtPIN);
  tempout = get_temp_out(reading);

  // recupère les infos du DHT11 pour la température et l'humidité
  humidity = dht.readHumidity();
  tempin = dht.readTemperature();

  difpositive = is_temp_positive(tempin, tempout);

  set_temp_flags(tempin, &hotTemp, &goodTemp, &coldTemp);

  // Module qualité d'air

  // si taux monoxide ou propane ou méthane, alerte utilisateur, ventilation + fenètre ouverte
  if (polluted) // regarder quand l'air est polluer sur le MQ9
  {
    if (!windowOpen)
    {
      // window opens
      open_window(&windowOpen);
    }
    if (!ventOn)
    {
      // ventilo switch on
      switch_vent_on(&ventOn);
    }
    // alerter l'utilisateur
    alerte_user(&alerteUser);
  }

  // si la température est trop élevée à l'intérieur
  else if (hotTemp)
  {
    // allumer la ventilation si elle ne l'est pas déjà
    if (!ventOn)
    {
      // ventilo switched on
      // ventOn = true;
      // +ventilo à 100%
      switch_vent_on(&ventOn);
    }
    if (difpositive)
    { // s'il fait moins chaud dehors
      if (!windowOpen)
      {
        // window opens
        open_window(&windowOpen);
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
  else if (coldTemp)
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
        open_window(&windowOpen);
      }
    }
  }

  else if (humidity > 80)
  {
    isHumid = true;
    open_window(&windowOpen);
  }

  // else il fait bon et l'air est pur
  else
  {
    if (!ventOn)
    {
      // ventilo switch on
      switch_vent_on(&ventOn);
    }
  }

  // Test la luminosité

  int ldrStatus = analogRead(ldrPin);
  if (ldrStatus <= 50)
  {
    Serial.print("Ils fait sombre, allume la lumière ! luminosité : ");
    Serial.println(ldrStatus);
  }
  else
  {
    Serial.print("Ils fait claire, eteint la lumière ! luminosité : ");
    Serial.println(ldrStatus);
  }

  // Partie dégâts des eaux - source : https://www.instructables.com/Water-Level-Alarm-Using-Arduino/

  readLevel = digitalRead(DegEauxInPIN); //DegEauxInPIN et LEDY agissent ensemble comme un interrupteur
  if (readLevel == LOW) //Le circuit est fermé
  {
    digitalWrite(LEDY, HIGH);
    analogWrite(motorDCPin, 255); // activation de la pompe au maximum
  }
  else
  {
    digitalWrite(LEDY, LOW);
    analogWrite(motorDCPin, 0); // désactivation de la pompe
  }

  /*// Partie incendie
  // Si MQ9 detecte un incendie (à regarder comment)
  digitalRead(ledIncendiePIN, HIGH);
  Serial.println("Incendie détecté")
      analogWrite(motorDCPin, 0); // switch off le ventilateur
  // servo moteur ferme la porte

  delay(2000);*/
}

void switch_vent_on(boolean *ventOn)
{
  float Ftemp = (temperature - 15) * (255 / 15);
  int Pw = min(255, max(0, Ftemp));
  analogWrite(motorDCPin, Pw);
  *ventOn = true;
}
void switch_vent_off(boolean *ventOn)
{
  analogWrite(motorDCPin, 0);
  *ventOn = false;
}

void open_window(boolean *windowOpen)
{
  Servo.write(90);
  *windowOpen = true;
}
void close_window(boolean *windowOpen)
{
  Servo.write(0);
  *windowOpen = false;
}

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
