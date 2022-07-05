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
        echo $result;
    }
    
    if (!empty($_POST["type_cmd"]) || !empty($_POST["cmd"])){
        if ($_POST["type_cmd"] == "w"){
            switch ($_POST["cmd"]){
                case "ventilation_on_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "ventilation_off_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "ventilation_power_input_range":
                    if (!empty($_POST["val"])){
                        $query = "";
                        update_actuators($conn, $query);
                    }
                    break;
                case "TempMin_input":
                    if (!empty($_POST["val"])){
                        $query = "";
                        update_actuators($conn, $query);
                    }
                    break;
                case "TempMax_input":
                    if (!empty($_POST["val"])){
                        $query = "";
                        update_actuators($conn, $query);
                    }
                    break;
                case "water_pump_on_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "water_pump_off_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "door_opened_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "door_closed_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "window_opened_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "window_closed_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "security_on_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "security_off_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "buzzer_on_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                case "buzzer_off_button":
                    $query = "";
                    update_actuators($conn, $query);
                    break;
                default;
                    break;
            }
        }
        else if ($_POST["cmd"] == "r"){

            function read($conn, $query)
            {
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result);
                    echo "";
                }
            }

            switch ($_POST["cmd"]) {
                case "ventilation_module_state":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "ventilation_power":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "TempMin":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "TempMax":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "water_pump_state":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "door_state":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "window_state":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "security_module_state":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "buzzer_state":
                    $query = "";
                    read($conn, $query);
                    break; 

                case "humidity":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "temperature":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "water":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "lpg":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "ch4":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "co":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "hcho":
                    $query = "";
                    read($conn, $query);
                    break; 
                case "human":
                    $query = "";
                    read($conn, $query);
                    break; 
                default;
                    break;
            }
        }   
    }
?>