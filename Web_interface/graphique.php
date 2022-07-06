<!DOCTYPE HTML>
<html>
    <head>
        <title>Graphiques</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    </head>
    <body>
        <header>
            <h1>Graphiques</h1>
            <div class = "boutonRetour">
                <a href="main_page.php">Retour</a>
            </div>
            <br>
            <button id="buttonTempsReel" type="button" onclick = affichageParDefaut()>Temps Reel</button>
            <button id="buttonDay" type="button">Day</button>
            <button id="buttonMonth" type="button">Month</button>
            <button id="buttonYear" type="button">Year</button>
        </header>
        <br>
        <canvas id="plotsTemperature" style="width:100%;max-width:700px"></canvas>
        <style>
            h1{
                color: black;
                margin-left:43%;
            }
            #plots{
                margin:auto;

            }
            a{
                background-color: blue;
                color:white;
                padding: 10px;
                border-radius: 10%;

            }
        </style>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            
            var list =[];

            var ladate=new Date();
            var dateDuJour = (ladate.getDate()+"-"+(ladate.getMonth()+1)+"-"+ladate.getFullYear());
            var moisActuel = ladate.getFullYear() + "-" + (ladate.getMonth() + 1);
            var anneeActuel = (ladate.getFullYear());

            var xaxis = [];
            var yaxis = [];

            var current_display = "real-time";

            function affichageParDefaut(){
                displayGraph("real-time");
            }

            affichageParDefaut();

            document.getElementById("buttonDay").onclick = function () {
                displayGraph("day");
            };

            document.getElementById("buttonMonth").onclick = function () {
                displayGraph("month");
            };

            document.getElementById("buttonYear").onclick = function () {
                displayGraph("year");
            };

            function displayGraph(new_display){

                xaxis = [];
                yaxis = [];
                for (let element = 0 ; element < list.length ; element++){

                    if(new_display == "real-time"){
                        yaxis.push(list[element][0]);
                        xaxis.push(list[element][1]);
                    }
                    
                    else if(new_display == "day"){
                        if(dateDuJour == list[element][1]){
                            yaxis.push(list[element][0]);
                            xaxis.push(list[element][1]);
                        }
                    }

                    else if(new_display == "month"){
                        console.log(list[element][1] + " : " + moisActuel);
                        if(list[element][1].startsWith(moisActuel)){
                            yaxis.push(list[element][0]);
                            xaxis.push(list[element][1]);
                        }
                    }

                    else if(new_display == "year"){
                        if(list[element][1].endsWith(anneeActuel)){
                            yaxis.push(list[element][0]);
                            xaxis.push(list[element][1]);
                        }
                    }
                };

                current_display = new_display;


                plotsTemp = document.getElementById("plotsTemperature");
                new Chart(plotsTemp, {
                    type: 'line',
                    data: {
                        labels: xaxis,
                        datasets: [{
                            data: yaxis,
                            backgroundColor: 'white',
                            borderColor: 'blue',
                            fill: false,
                        }]
                    },
                    options:{
                        legend: {display: false}, 
                        scales:{
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Temperature en °C'
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Temps en jours'
                                }
                            }]
                        }
                    } 
                });
            }

            function check_data(){
                $.ajax({
                    url:'database_link.php',
                    type: 'post',
                    data: {
                        'graph' : 1
                    },
                    success: function(response){
                        list = response.split("|");
                        for (var i = 0 ; i < list.length ; i++){
                            list[i] = list[i].split("_");
                        }
                        list.shift();
                        console.log(typeof list + " > " + list);
                    }
                });
                displayGraph(current_display);
                setTimeout("check_data()", 5000);
            }
            check_data();

        </script>
    </body>
</htm/>