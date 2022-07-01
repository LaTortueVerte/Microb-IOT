
# MicroB'IoT

An IoT solution to protect and monitor your belongings wherever and whenever you want.

It comes with plug & play modules to be adabpted 
to the users preferences.

---

Une solution IoT pour protéger et surveiller vos bien quand et où vous le souhaitez.

Celle-ci vient avec des modules plug & play.



## B'IoT

B'IoT are plug & play modules wich goes on the motherboard 
to add a sensor with his actuator.   

In order to realize this solution, we will use a set of programmable boards. 
First, an FPGA to which will be attached a camera and a PIR sensor (presence detector). 
Again, an Arduino on which can be attached modules according to the needs of users. 
These modules are therefore;  
DHT11 sensors that will send the temperature and humidity of the room to the user
A thermal camera and a MQ2 sensor that will detect the presence of smoke in the room. The actuator will open a water valve that will extinguish the fire 
A water level sensor that will detect a flood, the actuator will be here a small pump to empty the water.

Finally the last board will be a Raspberry Pi which will communicate with the Arduino and the FPGA using the UART protocol. 
This one allows first to make the link between the FPGA and the Arduino but especially to be able to make them communicate with the cloud via AWS. 

---


les B'IoT sont des modules plug & play qui s'ajoute aux module principal pour y ajouter un capteur avec son actionneur.


Afin de pouvoir réaliser cette solution, nous allons utiliser un ensemble de cartes programmables. 
D'abord, un FPGA auquel sera attaché une caméra ainsi qu'un PIR sensor (détecteur de présence). 
Encore, un Arduino sur lesquels pourront être attachés des modules selon les besoins des utilisateurs. 
Ces modules sont donc;  
Capteurs DHT11 qui renverra la température et l'humidité de la salle afin de la renvoyer à l'utilisateur
Une caméra thermique ainsi qu'un capteur MQ2 qui va détecter la présence de fumée dans la salle l'actionneur permettra ici d'ouvrir une valve d'eau qui éteindra l'incendie 
Un capteur de niveau d'eau qui détectera une inondation, l'actionneur sera ici une petite pompe pour vider l'eau.

Enfin le dernière carte sera un Raspberry Pi qui communiquera grâce au protocole UART avec l'Arduino ainsi qu'avec le FPGA. 
Celui-ci permet d’abord de faire le lien entre le FPGA et l’Arduino mais surtout de pouvoir les faire communiquer avec le cloud via AWS. 



## A little pitch

Are you looking for a solution that will allow you to secure your premises against the hazards of its environment and the actors who interact with it?  
We have THE solution!   
Our project, Microb'IoT, is an IOT solution securing all the rooms of a campus, a warehouse, a production line. In short, we allow you to monitor and ensure the security of your place of operation, in real time and anywhere on Earth thanks to the Cloud. 
This security will prevent floods, fires, air quality, power outages and intrusions.
It consists of plug & play security modules adapted to YOUR business. We offer you a security needs analysis conducted by our experts. After installation, log in and you can travel with peace of mind while keeping an eye on your production.
Our intelligent security modules are called B'IoT. They consist of a group of sensor blocks allowing to monitor in real time a room, to warn you in case of problem and to counter threats thanks to our integrated actuator systems.
With the Microb'IoT solution, you have the power to add as many security modules as you need, very easily. It is very simple to connect them securely to the local control computer which provides the link to the Cloud, allowing new updates and remote monitoring control. 

With Microb'IoT, control your premises whenever and wherever you want! 

Thank you for your attention. 
The RoB'IOT team hopes to see you soon. 

---

Vous recherchez une solution vous permettant de sécuriser vos locaux aux aléas de son environnement et des acteurs qui y interagissent ? 
Nous avons LA solution! 
Notre projet, Microb’IoT, est une solution IOT sécurisant l'ensemble des salles d'un campus, d'un entrepôt, d'une ligne de production. En bref nous vous permettons de surveiller et d’assurer la sécurité sur votre lieu d’exploitation, et ce, en temps réel et n’importe où sur Terre grâce au Cloud. 
Cette sécurité préviendra les inondations, les incendies, la qualité de l'air, les coupures électriques et les intrusions.
Elle se compose de modules de sécurité plug & play adaptés à VOTRE entreprise. Nous vous proposons une analyse des besoins en sécurité menée par nos experts. Après installation connectez-vous et vous pourrez voyager l’esprit léger en gardant un œil sur votre production.
Nos modules de sécurité intelligents s’appellent les B’IoT. Ils consistent en un groupe de blocs de capteurs permettant de surveiller en temps réel un local, de vous prévenir en cas de problème et de contrer les menaces grâce à nos systèmes d’actionneurs intégrés.
Avec la solution Microb’IoT, vous avez le pouvoir d’ajouter autant de modules de sécurité que vous avez besoin et ce, très facilement. Il est très simple de les connecter en toute sécurité à l’ordinateur de contrôle du local qui assure le lien avec le Cloud, permettant les nouvelles mises à jour et le contrôle de la surveillance à distance. 

Avec Microb’IoT, contrôlez vos locaux quand et où vous le souhaitez ! 

Merci de votre attention. 
L’équipe RoB’IOT espère vous retrouver bientôt. 



## Find files

Ce repository contient l'ensemble de nos fichiers de développement.

Nous avons d'une part le fichier MicrobIOT_captor_test.ino qui contient le code de nos modules liés à une même arduino (qualité d'air, présence de gaz toxiques ou inflamable et dégât des eaux). Vous y retrouver un orchestre de capteurs qui détectent le monoxide de carbone, le HCHO, le méthane, la vapeurs d'hydrocarbure, l'humidité, la température et la présence d'eau. Ces capteurs sont intelligents et sont liés à des actionneurs tels qu'un ventilateur, une pompe, un moteur qui ouvre une fenêtre. Une signalisation permet une interface locale avec les utilisateurs présents dans l'espace surveillé tels que des LED d'alerte et l'écran LCD qui fait apparaître les mesures des capteurs.

D'autre part, nous avons les fichiers VHDL qui composent le module de surveillance d'intrusion. 
Il y a le fichier Counter.vhd qui génère un timer qui va permettre l'envoi d'un signal à partir du moment où il est maintenu sur une durée, ce qui permet au FPGA de filtrer une partie du bruit des capteurs.
Le fichier PIRSensor.vhd permet le traitement du signal d'un capteur PIR. Ce capteur détecte la présence de quelqu'un se trouvant à sa portée et l'état de son signal est binaire.
Lorsque le capteur PIR détecte une personne, une caméra prend une photo de l'individu.
Il y a le fichier CameraSensor.vhd qui traite le signal de la caméra pour prendre une photo à chaque détection.
Evidemment, nous avons décidé de produire un toplevel et les testbenchs de ces composants pour les simuler avant de les implémenter sur le FPGA NEXYS VIDEO de la marque XILINX.

Les fichiers implémentés à ce jour sur la Raspberry Pi sont les fichiers Main.py et Module_Thread.py
Le fichier main reçoit les données de l'arduino (pour l'instant) et génère un thread par module grâce au fichier module_thread. Il va remplir l'instance de module avec les données des capteurs.

L'interface web n'étant pas terminée, nous avons pour l'instant la page d'accueil qui est dans le fichier main_page.php, la page de connexion login.php, la page d'inscription register.php, le fichier de déconnexion logout.php, le fichier de connexion à la database conn.php, ainsi que tous les fichiers de mise à jour des tables de la base de donnée.

Nous n'avons pas encore implémenté notre système sur le serveur AWS et nous avons reporté cette tâche au 5 Juillet, comme nous pouvons le vor sur le Trello.
   
 
## Authors

- [@LaTortueVerte](https://www.github.com/LaTortueVerte)
- [@JulesBuretteDev](https://www.github.com/JulesBuretteDev)
- [@Thiegox](https://www.github.com/Thiegox)
- [@BobLaMortadelle](https://www.github.com/BobLaMortadelle)
- [@Marine-Celer](https://www.github.com/Marine-Celer)
- [@Davidoo](https://www.github.com/JulesBuretteDev)


