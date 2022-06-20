#include "DHT.h"
#define DHTPIN A4       // detection de la température et de l'humidité
#define ldrPin A3       // detection de la luminosité
#define motorWaterPin 2 // actionneur moteur qui représente
#define motorDCPin 3    // actionneur moteur qui représente le ventilateur
#define DegEauxInPIN 4  // détecteur du niveau de l'eau dans le local
#define servmotorPIN 5  // actionneur moteur pour simuler l'ouverture/fermeture de la fenetre
#define IncendiePIN 6   // actionneur LED Rouge activation d'un sytème qui éteint l'incendie
#define mq9DOutPIN 8    // detection pin de sortie numérique du MQ9 pour les gaz
#define LEDAQ 9         // led alerte mauvaise qualité d'air
#define LEDY 10         // led alerte degat des eaux --> coupure électricité des prises de la pièce
#define LEDR 11         // led alerte incendit
#define mq9AOutPIN A2   // detection pin de sortie analogique du MQ9 pour les gaz

#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

monServomoteur.attach(servmotorPIN);

// Variables
int readLevel;
/*
float tempin;
float tempout;
float diftemp = tempin - tempout;
if(!diftemp){
  difpositive = false;
}*/

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

  pinMode(ldrPin, INPUT);
  pinMode(motorDCPin, OUTPUT);
  pinMode(servmotorPIN, OUTPUT);
  pinMode(IncendiePIN, OUTPUT);
  pinMode(DegEauxInPIN, INPUT);
  pinMode(LEDAQ, OUTPUT);
  pinMode(LEDY, OUTPUT);
  pinMode(LEDR, OUTPUT);
  pinMode(mq9DOutPIN, OUTPUT);
  pinMode(mq9AOutPIN, OUTPUT);
}

void loop()
{
  delay(2000);

  // recupère les infos du DHT11 pour la température et l'humidité
  float humidity = dht.readHumidity();
  float temperature = dht.readTemperature();

  // reinitialise les flags
  /*polluted = false;    // sensor
  hotTemp = false;     // sensor
  goodTemp = true;     // sensor
  coldTemp = false;    // sensor
  difpositive = false; // sensor
  isHumid = false;     // sensor
  ventOn = false;      // actionneur
  windowOpen = false;  // actionneur
  alerteUser = false;  // actionneur
*/
  // debut du module du check d'états

  // Module qualité d'air

  // si taux monoxide ou propane ou méthane, alerte utilisateur, ventilation + fenètre ouverte
  if (polluted) // regarder quand l'air est polluer sur le MQ9
  {
    if (!windowOpen)
    {
      // window opens
      open_window();
    }
    if (!ventOn)
    {
      // ventilo switch on
      switch_vent_on();
    }
    // alerter l'utilisateur
    void alerte_user();
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
      switchventOn();
    }
    if (difpositive)
    { // s'il fait moins chaud dehors
      if (!windowOpen)
      {
        // window opens
        open_window();
      }
    }
    else if (!difpositive)
    { // s'il fait plus chaud dehors
      if (windowOpen)
      {
        // window closes
        close_window();
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
      switch_vent_off();
    }
    if (difpositive)
    { // s'il fait moins chaud dehors
      if (windowOpen)
      {
        // window closes
        close_window();
      }
    }
    else if (!difpositive)
    {
      if (!windowOpen)
      {
        // window opens
        open_window();
      }
    }
  }

  else if (humidity > 80)
  {
    isHumid = true;
    open_window();
  }

  // else il fait bon et l'air est pur
  else
  {
    // ventilateur moins fort
  }

  // Affichage de l'humidité et de la température sur le moniteur série
  Serial.print(F("Humidity: "));
  Serial.print(humidity);
  Serial.print(F("%  Temperature: "));
  Serial.print(temperature);
  Serial.println(F("°C "));

  // Le moteur s'active si la température est trop élevée
  float Ftemp = (temperature - 15) * (255 / 15);
  int Pw = min(255, max(0, Ftemp));
  analogWrite(motorDCPin, Pw);

  //( Partie intrusion à utiliser sur FPGA )

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

  // Partie dégâts des eaux
  readLevel = digitalRead(DegEauxInPIN);
  if (readLevel == LOW)
  {
    digitalWrite(LEDY, HIGH);
    analogWrite(motorWaterPin, 255); // activation de la pompe au maximum
  }
  else
  {
    digitalWrite(LEDY, LOW);
    analogWrite(motorWaterPin, 0); // désactivation de la pompe
  }

  // Partie incendie
  // Si MQ9 detecte un incendie (à regarder comment)
  digitalRead(ledIncendiePIN, HIGH);
  Serial.println("Incendie détecté")
      analogWrite(motorDCPin, 0); // switch off le ventilateur
  // servo moteur ferme la porte

  /*
    // actionneurs

    if (difpositive == true)
    {
    }

    // Allume ou éteint la ventillation suivant la variable ventOn
    if (ventOn == true)
    {
      analogWrite(motorDCPin, HIGH);
    }
    else
    {
      analogWrite(motorDCPin, LOW);
    }

    // ouvre ou ferme la fenêtre suivant la variable windowOpen
    if (windowOpen == true)
    {
      Servo.write(180);
    }
    else
    {
      Servo.write(0);
    }

    // préviens l'utilisateur de la polution via la led jaune

    if (polluted == true)
    {
      analogWrite(LEDY, HIGH);
    }
    else
    {
      analogWrite(LEDY, LOW);
    }*/

  // changer les valeurs de la memoire
}

void switch_vent_on()
{
  analogWrite(motorDCPin, HIGH);
  ventOn = true;
}
void switch_vent_off()
{
  analogWrite(motorDCPin, LOW);
  ventOn = false;
}

void open_window()
{
  Servo.write(90);
  windowOpen = true;
}
void close_window()
{
  Servo.write(0);
  windowOpen = false;
}

void alerte_user()
{
  digitalWrite(LEDAQ, HIGH);
  alerteUser = true;
}
void finish_user_alerte()
{
  digitalWrite(LEDAQ, LOW);
  alerteUser = false;
}
