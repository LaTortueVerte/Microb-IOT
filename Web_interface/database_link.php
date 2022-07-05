<?php

    /* 
    Role of this file :

    Manage several action with the database :
        - Modify Actuator variables with the main_page.php
        - Retrieve data from sensor 
    */

    require('conn.php');
    session_start();

    if (!empty($_POST["type_cmd"]) || !empty($_POST["cmd"])){
        if ($_POST["type_cmd"] == "w"){
            switch ($_POST["cmd"]) {
                case "ventilation_on_button":
                    // sql
                    echo "ventilation_on_button";
                    break;
                case "ventilation_off_button":
                    // sql
                    echo "ventilation_off_button";
                    break;
                case "ventilation_power_input_range":
                    if (!empty($_POST["val"])){
                        echo "ventilation_power_input_range : ".$_POST["val"];
                        // sql
                    }
                    break;
                case "TempMin_input":
                    if (!empty($_POST["val"])){
                        echo "TempMin_input : ".$_POST["val"];
                        // sql
                    }
                    break;
                case "TempMax_input":
                    if (!empty($_POST["val"])){
                        echo "TempMax_input : ".$_POST["val"];
                        // sql
                    }
                    break;
                case "water_pump_on_button":
                    // sql
                    echo "water_pump_on_button";
                    break;
                case "water_pump_off_button":
                    // sql
                    echo "water_pump_off_button";
                    break;
                case "door_opened_button":
                    // sql
                    echo "door_opened_button";
                    break;
                case "door_closed_button":
                    // sql
                    echo "door_closed_button";
                    break;
                case "window_opened_button":
                    // sql
                    echo "window_opened_button";
                    break;
                case "window_closed_button":
                    // sql
                    echo "window_closed_button";
                    break;
                case "security_on_button":
                    // sql
                    echo "security_on_button";
                    break;
                case "security_off_button":
                    // sql
                    echo "security_off_button";
                    break;
                case "buzzer_on_button":
                    // sql
                    echo "buzzer_on_button";
                    break;
                case "buzzer_off_button":
                    // sql
                    echo "buzzer_off_button";
                    break;
                default;
                    break;
            }
        }
        else if ($_POST["cmd"] == "r"){

        }   
    }

?>

