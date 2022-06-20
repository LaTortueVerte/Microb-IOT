#include "DHT.h"
#define DHTPIN A4          // detection de la température et de l'humidité
#define ldrPin A3          // detection de la luminosité
#define motorDCPin 3       // actionneur moteur qui représente le ventilateur
#define servmotorPIN 5     // actionneur moteur pour simuler l'ouverture/fermeture de la fenetre
#define ledIncendiePIN 6   // actionneur LED Rouge activation d'un sytème qui éteint l'incendie
#define ledDegEauxInPIN 4  // détecteur du niveau de l'eau dans le local
#define ledDegEauxOutPIN 7 // actionneur LED Bleu coupure électricité des prises de la pièce
#define mq9DOutPIN 8       // detection pin de sortie numérique du MQ9 pour les gaz
#define mq9AOutPIN A2      // detection pin de sortie analogique du MQ9 pour les gaz
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

int readLevel;

void setup()
{
  Serial.begin(9600);
  dht.begin();
  pinMode(ldrPin, INPUT);
  pinMode(motorDCPin, OUTPUT);
  pinMode(servmotorPIN, OUTPUT);
  pinMode(ledIncendiePIN, OUTPUT);
  pinMode(ledDegEauxInPIN, INPUT);
  pinMode(ledDegEauxOutPIN, OUTPUT);
  pinMode(mq9DOutPIN, OUTPUT);
  pinMode(mq9AOutPIN, OUTPUT);
}

void loop()
{
  // Module qualité d'air
  // si taux monoxide ou propane ou méthane, alerte utilisateur, ventilation + fenètre ouverte
  // si température trop élevée à l'intérieur et ok à l'extérieur
  // ouverture fenètre et ventilation
  // else if température
  delay(2000);
  // recupère les infos du DHT11 pour la température et l'humidité
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  // Affichage de l'humidité et de la température sur le moniteur série
  Serial.print(F("Humidity: "));
  Serial.print(h);
  Serial.print(F("%  Temperature: "));
  Serial.print(t);
  Serial.println(F("°C "));

  // Le moteur s'active si la température est trop élevée
  float Ftemp = (t - 15) * (255 / 15);
  int Pw = min(255, max(0, Ftemp));
  analogWrite(motorDCPin, Pw);

  // Partie intrusion à utiliser sur FPGA
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
  readLevel = digitalRead(ledDegEauxInPIN);

  // Partie incendie
  // Si MQ9 detecte un incendie (à regarder comment)
  digitalRead(ledIncendiePIN, HIGH);
  Serial.println("Incendie détecté")
      analogWrite(motorDCPin, 0); // switch off le ventilateur
  // servo moteur ferme la porte
}
