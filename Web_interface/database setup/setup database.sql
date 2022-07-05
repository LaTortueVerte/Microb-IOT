use microbiot_web_interface;

DROP TABLE IF EXISTS belongs;
DROP TABLE IF EXISTS data_component;
DROP TABLE IF EXISTS timeout;
DROP TABLE IF EXISTS logs;
DROP TABLE IF EXISTS component;
DROP TABLE IF EXISTS component_catalogue;
DROP TABLE IF EXISTS modules;
DROP TABLE IF EXISTS users;

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
   log_variable INT,
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
   data_variable INT,
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