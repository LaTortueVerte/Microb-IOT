<?php

    /* 
    Role of this file :

    Manage several action with the database :
        - Modify Actuator variables with the main_page.php
        - Retrieve data from sensor 
    */

    require('conn.php');
    session_start();

    function update_actuators($conn, $query){
        $result = mysqli_query($conn, $query);
    }

    function read($conn, $query)
    {
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            echo $row["data_valeur"];
        }
    }
    
    if (!empty($_POST["type_cmd"]) || !empty($_POST["cmd"])){
        if ($_POST["type_cmd"] == "w"){
            switch ($_POST["cmd"]){
                case "ventilation_on_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 1
                    WHERE data_variable = 'Etat_ventilateur';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_ventilateur';";
                    read($conn, $query);
                    break;
                case "ventilation_off_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 0
                    WHERE data_variable = 'Etat_ventilateur';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_ventilateur';";
                    read($conn, $query);
                    break;
                case "ventilation_power_input_range":
                    if (!empty($_POST["val"])){
                        $query = "select dc.data_valeur from data_component dc 
                        inner join component c
                            on dc.component_ID = c.component_ID 
                        inner join modules m
                            on c.module_ID = m.module_ID
                        inner join belongs b
                            on m.module_ID = b.module_ID
                        inner join users u
                            on b.user_ID = u.user_ID
                        where data_variable = 'Puissance_ventilateur';";
                        update_actuators($conn, $query);
                        $query = "select dc.data_valeur from data_component dc 
                        inner join component c
                            on dc.component_ID = c.component_ID 
                        inner join modules m
                            on c.module_ID = m.module_ID
                        inner join belongs b
                            on m.module_ID = b.module_ID
                        inner join users u
                            on b.user_ID = u.user_ID
                        where data_variable = 'temperature_min';";
                        read($conn, $query);
                    }
                    break;
                case "TempMin_input":
                    if (!empty($_POST["val"])){
                        $query = "UPDATE data_component dc
                        inner join component c
                            on dc.component_ID = c.component_ID 
                        inner join modules m
                            on c.module_ID = m.module_ID
                        inner join belongs b
                            on m.module_ID = b.module_ID
                        inner join users u
                            on b.user_ID = u.user_ID     
                        set  data_valeur = ".$_POST["val"]."
                        WHERE data_variable = 'temperature_min';";
                        update_actuators($conn, $query);
                        $query = "select dc.data_valeur from data_component dc 
                        inner join component c
                            on dc.component_ID = c.component_ID 
                        inner join modules m
                            on c.module_ID = m.module_ID
                        inner join belongs b
                            on m.module_ID = b.module_ID
                        inner join users u
                            on b.user_ID = u.user_ID
                        where data_variable = 'temperature_min';";
                        read($conn, $query);
                    }
                    break;
                case "TempMax_input":
                    if (!empty($_POST["val"])){
                        $query = "UPDATE data_component dc
                        inner join component c
                            on dc.component_ID = c.component_ID 
                        inner join modules m
                            on c.module_ID = m.module_ID
                        inner join belongs b
                            on m.module_ID = b.module_ID
                        inner join users u
                            on b.user_ID = u.user_ID     
                        set  data_valeur = ".$_POST["val"]."
                        WHERE data_variable = 'temperature_max';";
                        update_actuators($conn, $query);
                        $query = "select dc.data_valeur from data_component dc 
                        inner join component c
                            on dc.component_ID = c.component_ID 
                        inner join modules m
                            on c.module_ID = m.module_ID
                        inner join belongs b
                            on m.module_ID = b.module_ID
                        inner join users u
                            on b.user_ID = u.user_ID
                        where data_variable = 'temperature_max';";
                        read($conn, $query);
                    }
                    break;
                case "water_pump_on_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 1
                    WHERE data_variable = 'Etat_Pompe';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_pompe';";
                    read($conn, $query);
                    break;
                case "water_pump_off_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 0
                    WHERE data_variable = 'Etat_Pompe';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_pompe';";
                    read($conn, $query);
                    break;
                case "door_opened_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 1
                    WHERE data_variable = 'Etat_Porte';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_porte';";
                    read($conn, $query);
                    break;
                case "door_closed_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 0
                    WHERE data_variable = 'Etat_Porte';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_porte';";
                    read($conn, $query);
                    break;
                case "window_opened_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 1
                    WHERE data_variable = 'Etat_fenetre';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_fenetre';";
                    read($conn, $query);
                    break;
                case "window_closed_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 0
                    WHERE data_variable = 'Etat_fenetre';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_fenetre';";
                    read($conn, $query);
                    break;
                case "security_on_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 1
                    WHERE data_variable = 'Etat_intrusion';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_intrusion';";
                    read($conn, $query);
                    break;
                case "security_off_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 0
                    WHERE data_variable = 'Etat_intrusion';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_intrusion';";
                    read($conn, $query);
                    break;
                case "buzzer_on_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 1
                    WHERE data_variable = 'Etat_buzzer';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_buzzer';";
                    read($conn, $query);
                    break;
                case "buzzer_off_button":
                    $query = "UPDATE data_component dc
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID     
                    set  data_valeur = 0
                    WHERE data_variable = 'Etat_buzzer';";
                    update_actuators($conn, $query);
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_buzzer';";
                    read($conn, $query);
                    break;
                default;
                    break;
            }
        }
        else if ($_POST["cmd"] == "r"){
            switch ($_POST["cmd"]) {
                case "ventilation_module_state":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_ventilateur';";
                    read($conn, $query);
                    break; 
                case "ventilation_power":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Puissance_ventilateur';";
                    read($conn, $query);
                    break; 
                case "TempMin":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'temperature_min';";
                    read($conn, $query);
                    break; 
                case "TempMax":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'temperature_max';";
                    read($conn, $query);
                    break; 
                case "water_pump_state":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_pompe';";
                    read($conn, $query);
                    break; 
                case "door_state":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_porte';";
                    read($conn, $query);
                    break; 
                case "window_state":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_fenetre';";
                    read($conn, $query);
                    break; 
                case "security_module_state":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_intrusion';";
                    read($conn, $query);
                    break; 
                case "buzzer_state":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Etat_buzzer';";
                    read($conn, $query);
                    break; 

                case "humidity":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Humidity';";
                    read($conn, $query);
                    break; 
                case "temperature":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Temperature';";
                    read($conn, $query);
                    break; 
                case "water":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Presence_eau';";
                    read($conn, $query);
                    break; 
                case "lpg":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'LGP';";
                    read($conn, $query);
                    break; 
                case "ch4":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'CH4';";
                    read($conn, $query);
                    break; 
                case "co":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'CO';";
                    read($conn, $query);
                    break; 
                case "hcho":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'HCHO';";
                    read($conn, $query);
                    break; 
                case "human":
                    $query = "select dc.data_valeur from data_component dc 
                    inner join component c
                        on dc.component_ID = c.component_ID 
                    inner join modules m
                        on c.module_ID = m.module_ID
                    inner join belongs b
                        on m.module_ID = b.module_ID
                    inner join users u
                        on b.user_ID = u.user_ID
                    where data_variable = 'Presence_humain';";
                    read($conn, $query);
                    break; 
                default;
                    break;
            }
        }   
    }
?>