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
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: login.php");
        exit(); 
    }
    else
    {
        header("Location: main_page.php");
        exit(); 
    }
    <nav>
        <h1>Microb'IoT</h1>
        <img src="./image/LOGOMASTERCAMP.png" alt="Logo Rob'IoT" height="80px" width="140px">
        <button type="button" class="btn btn-outline-primary">LogOut</button>
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
                    <button type="button" class="btn btn-success btn-sm">ON</button>
                    <button type="button" class="btn btn-danger btn-sm">OFF</button>
                </td>
                <td>Etat du ventilo depuis php</td>
            </tr>
            <tr>
                <th scope="row">Puissance de ventilation</th>
                <td>
                    <input type="range" id="ventilation" name="ventilation" min="0" max="100">
                </td>
                <td>Etat du ventilo depuis php</td>
            </tr>
            <tr>
                <th scope="row">Température Min</th>
                <td>
                <input type="number" id="TempMin" name="TempMin" placeholder="18" step ="0.5" min="0" max="50">
                </td>
                <td>Etat temp min depuis php</td>
            </tr>
            <tr>
                <th scope="row">Température Max</th>
                <td>
                <input type="number" id="TempMax" name="TempMax" placeholder="24" step ="0.5" min="0" max="50">
                </td>
                <td>Etat temp max depuis php</td>
            </tr>
            <tr>
                <th scope="row">Pompe à eau</th>
                <td>
                    <button type="button" class="btn btn-success btn-sm">ON</button>
                    <button type="button" class="btn btn-danger btn-sm">OFF</button>
                </td>
                <td>Etat de la pompe depuis php</td>
            </tr>
            <tr>
                <th scope="row">Porte</th>
                <td>
                    <button type="button" class="btn btn-success btn-sm">Ouvert</button>
                    <button type="button" class="btn btn-danger btn-sm">Fermé</button>
                </td>
                <td>Etat de la porte depuis php</td>
            </tr>
            <tr>
                <th scope="row">Fenetre</th>
                <td>
                    <button type="button" class="btn btn-success btn-sm">Ouvert</button>
                    <button type="button" class="btn btn-danger btn-sm">Fermé</button>
                </td>
                <td>Etat de la fenetre depuis php</td>
            </tr>
            <tr>
                <th scope="row">Module intrusion</th>
                <td>
                    <button type="button" class="btn btn-success btn-sm">ON</button>
                    <button type="button" class="btn btn-danger btn-sm">OFF</button>
                </td>
                <td>Etat du module intrusion depuis php</td>
            </tr>
            <tr>
                <th scope="row">Buzzer</th>
                <td>
                    <button type="button" class="btn btn-success btn-sm">ON</button>
                    <button type="button" class="btn btn-danger btn-sm">OFF</button>
                </td>
                <td>Etat du buzzer depuis php</td>
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
                <td>Valeure</td>
            </tr>
            <tr>
                <th scope="row">Température</th>
                <td>Valeure</td>
            </tr>
            <tr>
                <th scope="row">Présence d'eau</th>
                <td>Valeure</td>
            </tr>
            <tr>
                <th scope="row">LGP (Gaz de pétrole liquéfié)</th>
                <td>Valeure</td>
            </tr>
            <tr>
                <th scope="row">CH4 (méthane)</th>
                <td>Valeure</td>
            </tr>
            <tr>
                <th scope="row">CO (monoxyde de carbone))</th>
                <td>Valeure</td>
            </tr>
            <tr>
                <th scope="row">HCHO (formaldéhyde)</th>
                <td>Valeure</td>
            </tr>
            <tr>
                <th scope="row">Présence humaine</th>
                <td>Valeure</td>
            </tr>
        </tbody>


    </table>

</body>
</html>