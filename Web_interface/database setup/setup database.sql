use microbiot_web_interface;

DROP TABLE IF EXISTS belongs;
DROP TABLE IF EXISTS data_component;
DROP TABLE IF EXISTS timeout;
DROP TABLE IF EXISTS logs;
DROP TABLE IF EXISTS component;
DROP TABLE IF EXISTS component_catalogue;
DROP TABLE IF EXISTS modules;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS graph;

CREATE TABLE users(
   user_ID INT NOT NULL AUTO_INCREMENT,
   user_email VARCHAR(255),
   user_name VARCHAR(50),
   user_pwd VARCHAR(50),
   user_role INT,
   PRIMARY KEY(user_ID)
);

CREATE TABLE modules(
   module_ID INT NOT NULL AUTO_INCREMENT,
   module_role INT,
   module_name VARCHAR(50),
   PRIMARY KEY(module_ID)
);

CREATE TABLE component_catalogue(
   component_catalogue_ID INT NOT NULL AUTO_INCREMENT,
   component_catalogue_name VARCHAR(50),
   component_catalogue_role INT,
   PRIMARY KEY(component_catalogue_ID)
);

CREATE TABLE logs(
   log_ID INT NOT NULL AUTO_INCREMENT,
   log_datetime DATETIME,
   log_variable VARCHAR(255),
   log_done BOOLEAN,
   log_value DOUBLE,
   module_ID INT NOT NULL,
   PRIMARY KEY(log_ID),
   FOREIGN KEY(module_ID) REFERENCES modules(module_ID)
);

CREATE TABLE timeout(
   timeout_ID INT NOT NULL AUTO_INCREMENT,
   timeout_datetime DATETIME,
   module_ID INT NOT NULL,
   PRIMARY KEY(timeout_ID),
   FOREIGN KEY(module_ID) REFERENCES modules(module_ID)
);

CREATE TABLE component(
   component_ID INT NOT NULL AUTO_INCREMENT,
   module_ID INT,
   component_catalogue_ID INT,
   PRIMARY KEY(component_ID),
   FOREIGN KEY(module_ID) REFERENCES modules(module_ID),
   FOREIGN KEY(component_catalogue_ID) REFERENCES component_catalogue(component_catalogue_ID)
);

CREATE TABLE data_component(
   data_ID INT NOT NULL AUTO_INCREMENT,
   data_variable VARCHAR(255),
   data_valeur DOUBLE,
   component_ID INT NOT NULL,
   PRIMARY KEY(data_ID),
   FOREIGN KEY(component_ID) REFERENCES component(component_ID)
);

CREATE TABLE belongs(
   belong_ID INT NOT NULL AUTO_INCREMENT,
   user_ID INT,
   module_ID INT,
   PRIMARY KEY(belong_ID),
   FOREIGN KEY(user_ID) REFERENCES users(user_ID),
   FOREIGN KEY(module_ID) REFERENCES modules(module_ID)
);

CREATE TABLE graph ( 
   graph_ID INT NOT NULL AUTO_INCREMENT ,  
   graph_event DATETIME NOT NULL ,
   graph_variable DOUBLE NOT NULL ,    
   PRIMARY KEY  (graph_ID)
) ENGINE = InnoDB;

INSERT INTO `users` (`user_ID`, `user_email`, `user_name`, `user_pwd`, `user_role`) VALUES ('1', 'user@mail.com', 'user1', 'c92e5ffb0d3cd851b0609410147692f6', '0'); -- tortue
INSERT INTO `component_catalogue` (`component_catalogue_ID`, `component_catalogue_name`, `component_catalogue_role`) VALUES ('1', 'Ventilateur3000', '1'); -- composant ventilateur
INSERT INTO `component_catalogue` (`component_catalogue_ID`, `component_catalogue_name`, `component_catalogue_role`) VALUES (NULL, 'TemperatureSeter3000', '0'); -- composant thermometre
INSERT INTO `component_catalogue` (`component_catalogue_ID`, `component_catalogue_name`, `component_catalogue_role`) VALUES (NULL, 'Pompe3000', '1'); -- composant pompe
INSERT INTO `component_catalogue` (`component_catalogue_ID`, `component_catalogue_name`, `component_catalogue_role`) VALUES (NULL, 'Porte3000', '1'); -- composant porte
INSERT INTO `component_catalogue` (`component_catalogue_ID`, `component_catalogue_name`, `component_catalogue_role`) VALUES (NULL, 'Fenetre3000', '1'); -- composant fenetre
INSERT INTO `component_catalogue` (`component_catalogue_ID`, `component_catalogue_name`, `component_catalogue_role`) VALUES (NULL, 'Intrusion3000', '1'); -- composant intrusion
INSERT INTO `component_catalogue` (`component_catalogue_ID`, `component_catalogue_name`, `component_catalogue_role`) VALUES (NULL, 'Buzzer3000', '1'); -- composant buzzer
INSERT INTO `component_catalogue` (`component_catalogue_ID`, `component_catalogue_name`, `component_catalogue_role`) VALUES (NULL, 'Humidite3000', '0'), (NULL, 'Temperature3000', '0'), (NULL, 'Eau3000', '0'), (NULL, 'LGP3000', '0'), (NULL, 'CH43000', '0'), (NULL, 'CO3000', '0'), (NULL, 'HCHO3000', '0'), (NULL, 'Humain3000', '0'); -- composant capteurs
INSERT INTO `modules` (`module_ID`, `module_role`, `module_name`) VALUES ('1', '0', 'qualité d\'aire'), ('2', '0', 'dégât des eaux'), ('3', '0', 'incendie'), ('4', '1', 'intrusion');
INSERT INTO `belongs` (`belong_ID`, `user_ID`, `module_ID`) VALUES ('1', '1', '1'), (NULL, '1', '2'), (NULL, '1', '3'), (NULL, '1', '4');

-- données concernant le ventilateur
INSERT INTO `component` (`component_ID`, `module_ID`, `component_catalogue_ID`) VALUES ('1', 1, 1);
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES ('1', '90', '1', 'Puissance_ventilateur');
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES (NULL, '1', '1', 'Etat_ventilateur');

-- données concernant le thermomètre
INSERT INTO `component` (`component_ID`, `module_ID`, `component_catalogue_ID`) VALUES (NULL, '1', '2');
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES (NULL, '18', '2', 'temperature_min'), (NULL, '24', '2', 'temperature_max');

-- données concernant la pompe à eau
INSERT INTO `component` (`component_ID`, `module_ID`, `component_catalogue_ID`) VALUES (NULL, '2', '3');
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES (NULL, '1', '3', 'Etat_pompe');

-- données concernant la porte
INSERT INTO `component` (`component_ID`, `module_ID`, `component_catalogue_ID`) VALUES (NULL, '4', '4');
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES (NULL, '1', '4', 'Etat_porte');

-- données concernant la porte
INSERT INTO `component` (`component_ID`, `module_ID`, `component_catalogue_ID`) VALUES (NULL, '1', '15');
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES (NULL, '1', '5', 'Etat_fenetre');

-- données concernant le module intrusion
INSERT INTO `component` (`component_ID`, `module_ID`, `component_catalogue_ID`) VALUES (NULL, '4', '5');
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES (NULL, '1', '6', 'Etat_intrusion');

-- données concernant le buzzer
INSERT INTO `component` (`component_ID`, `module_ID`, `component_catalogue_ID`) VALUES (NULL, '4', '6');
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES (NULL, '1', '7', 'Etat_buzzer');

-- données concernant les capteurs
INSERT INTO `component` (`component_ID`, `module_ID`, `component_catalogue_ID`) VALUES (NULL, '1', '7'), (NULL, '1', '8'), (NULL, '2', '9'), (NULL, '3', '10'), (NULL, '3', '11'), (NULL, '3', '12'), (NULL, '3', '13'), (NULL, '4', '14');
INSERT INTO `data_component` (`data_ID`, `data_valeur`, `component_ID`, `data_variable`) VALUES (NULL, '0', '8', 'Humidity'), (NULL, '0', '9', 'Temperature'), (NULL, '0', '10', 'Presence_eau'), (NULL, '0', '11', 'LGP'), (NULL, '0', '12', 'CH4'), (NULL, '0', '13', 'CO'), (NULL, '0', '14', 'HCHO'), (NULL, '0', '15', 'Presence_humain');
