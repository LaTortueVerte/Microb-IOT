<?php
    session_start();
    if(!isset($_SESSION["nameUser"]))
    {
        header("Location: login.php");
        exit(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microb'Iot Interface</title>
    <link rel="stylesheet" href="main_page.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    
</head>
<body>
    <?php
        require('conn.php');
    
        $queries = ["", "", ""]; // get value of ventilation power ; minTemp ; maxTemp
        $value = [];

        foreach ($queries as $query) {
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                array_push($value, $row["data_valeur"]);
            }
        }

    ?>

    <nav>
        <h1>Microb'IoT</h1>
        <img src="./image/LOGOMASTERCAMP.png" alt="Logo Rob'IoT" height="80px" width="140px">
        <button id='logout_button' type="button" class="btn btn-outline-primary">LogOut</button>

    </nav>
    <div class="second-nav-bar">
        <button type="button" class="btn btn-outline-primary">Graphiques</button>
        <button type="button" class="btn btn-outline-primary">Modules</button>
    </div>


    <table>
        <thead>
            <tr>
                <th scope="col">Actionneurs</th>
                <th scope="col">Actions</th>
                <th scope="col">État</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Ventilation</th>
                <td>
                    <button type="button" id="ventilation_on_button" class="btn btn-success btn-sm">ON</button>
                    <button type="button" id="ventilation_off_button" class="btn btn-danger btn-sm">OFF</button>
                </td>
                <td id="ventilation_module_state">Etat du ventilo depuis php</td>
            </tr>
            <tr>
                <th scope="row">Puissance de ventilation</th>
                <td>
                    <input type="range" id="ventilation_power_input_range" name="ventilation" value="<?php echo $value[0]; ?>" min="0" max="100" onchange="change_ventilation_power()">
                </td>
                <td id="ventilation_power">Etat du ventilo depuis php</td>
            </tr>
            <tr>
                <th scope="row">Température Min</th>
                <td>
                <input type="number" id="TempMin_input" name="TempMin" value="<?php echo $value[1]; ?>" step ="0.5" min="0" max="50" onchange="change_min_temp()">
                </td>
                <td id="TempMin">Etat temp min depuis php</td>
            </tr>
            <tr>
                <th scope="row">Température Max</th>
                <td>
                <input type="number" id="TempMax_input" name="TempMax" value="<?php echo $value[2]; ?>" step ="0.5" min="0" max="50" onchange="change_max_temp()">
                </td>
                <td id="TempMax">Etat temp max depuis php</td>
            </tr>
            <tr>
                <th scope="row">Pompe à eau</th>
                <td>
                    <button type="button" id="water_pump_on_button" class="btn btn-success btn-sm">ON</button>
                    <button type="button" id="water_pump_off_button" class="btn btn-danger btn-sm">OFF</button>
                </td>
                <td id="water_pump_state">Etat de la pompe depuis php</td>
            </tr>
            <tr>
                <th scope="row">Porte</th>
                <td>
                    <button type="button" id="door_opened_button" class="btn btn-success btn-sm">Ouvert</button>
                    <button type="button" id="door_closed_button" class="btn btn-danger btn-sm">Fermé</button>
                </td>
                <td id="door_state">Etat de la porte depuis php</td>
            </tr>
            <tr>
                <th scope="row">Fenetre</th>
                <td>
                    <button type="button" id="window_opened_button" class="btn btn-success btn-sm">Ouvert</button>
                    <button type="button" id="window_closed_button" class="btn btn-danger btn-sm">Fermé</button>
                </td>
                <td id="window_state">Etat de la fenetre depuis php</td>
            </tr>
            <tr>
                <th scope="row">Module intrusion</th>
                <td>
                    <button type="button" id="security_on_button" class="btn btn-success btn-sm">ON</button>
                    <button type="button" id="security_off_button" class="btn btn-danger btn-sm">OFF</button>
                </td>
                <td id="security_module_state">Etat du module intrusion depuis php</td>
            </tr>
            <tr>
                <th scope="row">Buzzer</th>
                <td>
                    <button type="button" id="buzzer_on_button" class="btn btn-success btn-sm">ON</button>
                    <button type="button" id="buzzer_off_button" class="btn btn-danger btn-sm">OFF</button>
                </td>
                <td id="buzzer_state">Etat du buzzer depuis php</td>
            </tr>
        </tbody>
    </table>

    <table>
    <thead>
        <thead>
            <tr>
                <th scope="col">Capteurs</th>
                <th scope="col">Valeur</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Humidité</th>
                <td id="humidity">Valeure</td>
            </tr>
            <tr>
                <th scope="row">Température</th>
                <td id="temperature">Valeure</td>
            </tr>
            <tr>
                <th scope="row">Présence d'eau</th>
                <td id="water">Valeure</td>
            </tr>
            <tr>
                <th scope="row">LGP (Gaz de pétrole liquéfié)</th>
                <td id="lpg">Valeure</td>
            </tr>
            <tr>
                <th scope="row">CH4 (méthane)</th>
                <td id="ch4">Valeure</td>
            </tr>
            <tr>
                <th scope="row">CO (monoxyde de carbone))</th>
                <td id="co">Valeure</td>
            </tr>
            <tr>
                <th scope="row">HCHO (formaldéhyde)</th>
                <td id="hcho">Valeure</td>
            </tr>
            <tr>
                <th scope="row">Présence humaine</th>
                <td id="human">Valeure</td>
            </tr>
        </tbody>


    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">

        // -----------------------------------------------------------------------
        // Button & Input Events 
        // -----------------------------------------------------------------------

        function update_float_val(type_cmd, cmd, val){
            $.ajax({
                url:'database_link.php',
                type: 'post',
                data: {
                    'type_cmd' : type_cmd,
                    'cmd' : cmd,
                    'val' : val
                },
                success: function(response){
                    if (cmd == 'type_cmd'){
                        console.log(" > " + $("#" + cmd).text());
                        $("#" + cmd).text(response);
                    }
                }
            });
        }

        function update_bool_val(type_cmd, cmd){
            $.ajax({
                url:'database_link.php',
                type: 'post',
                data: {
                    'type_cmd' : type_cmd,
                    'cmd' : cmd
                },
                success: function(response){
                    console.log(" > " + $("#" + cmd).text());
                    $("#" + cmd).text(response);
                }
            });
        }

        // LogOut button event
        document.getElementById("logout_button").onclick = function () {
            location.href = "logout.php";
        };

        // Ventilation On button
        document.getElementById("ventilation_on_button").onclick = function () {
            update_bool_val('w', 'ventilation_on_button');
        };

        // Ventilation Off button
        document.getElementById("ventilation_off_button").onclick = function () {
            update_bool_val('w', 'ventilation_off_button');
        };
        
        // Ventilation power input range
        function change_ventilation_power() {
            var input_range = document.getElementById("ventilation_power_input_range");
            update_float_val('w', 'ventilation_power_input_range', input_range.value);
        }

        // Minimum temperature
        function change_min_temp() {
            var text_input = document.getElementById("TempMin_input");
            update_float_val('w', 'TempMin_input', text_input.value);
        }

        // Maximum temperature
        function change_max_temp() {
            var text_input = document.getElementById("TempMax_input");
            update_float_val('w', 'TempMax_input', text_input.value);
        }

        // Water pump ON button
        document.getElementById("water_pump_on_button").onclick = function () {
            update_bool_val('w', 'water_pump_on_button');
        };

        // Water pump OFF button
        document.getElementById("water_pump_off_button").onclick = function () {
            update_bool_val('w', 'water_pump_off_button');
        };

        // Door opened button
        document.getElementById("door_opened_button").onclick = function () {
            update_bool_val('w', 'door_opened_button');
        };

        // Door closed button
        document.getElementById("door_closed_button").onclick = function () {
            update_bool_val('w', 'door_closed_button');
        };

        // Window opened button
        document.getElementById("window_opened_button").onclick = function () {
            update_bool_val('w', 'window_opened_button');
        };

        // Window closed button
        document.getElementById("window_closed_button").onclick = function () {
            update_bool_val('w', 'window_closed_button');
        };

        // Security ON button
        document.getElementById("security_on_button").onclick = function () {
            update_bool_val('w', 'security_on_button');
        };

        // Security OFF button
        document.getElementById("security_off_button").onclick = function () {
            update_bool_val('w', 'security_off_button');
        };

        // Buzzer ON Buzzer
        document.getElementById("buzzer_on_button").onclick = function () {
            update_bool_val('w', 'buzzer_on_button');
        };
        
        // Buzzer OFF Buzzer
        document.getElementById("buzzer_off_button").onclick = function () {
            update_bool_val('w', 'buzzer_off_button');
        };

        // -----------------------------------------------------------------------
        // Automatic fetching
        // -----------------------------------------------------------------------

        function check_sensors_and_actuators(){

            // Actuators

            update_bool_val('r', 'ventilation_module_state');
            update_bool_val('r', 'ventilation_power');
            update_bool_val('r', 'TempMin');
            update_bool_val('r', 'TempMax');
            update_bool_val('r', 'water_pump_state');
            update_bool_val('r', 'door_state');
            update_bool_val('r', 'window_state');
            update_bool_val('r', 'security_module_state');
            update_bool_val('r', 'buzzer_state');

            // Sensors

            update_bool_val('r', 'humidity');
            update_bool_val('r', 'temperature');
            update_bool_val('r', 'water');
            update_bool_val('r', 'lpg');
            update_bool_val('r', 'ch4');
            update_bool_val('r', 'co');
            update_bool_val('r', 'hcho');
            update_bool_val('r', 'human');

            setTimeout("check_sensors_and_actuators()", 5000);
        }
        check_sensors_and_actuators();

    </script>   
</body>
</html>