
var list =[['12', '5-7-2022'], ['10', '5-7-2022'], ['15', '6-7-2022'], ['19', '6-7-2022'], ['9', '7-7-2022'], ['9', '7-8-2022'], ['9', '7-8-2022'], ['9', '7-7-2023'], ['9', '7-7-2023'], ];

var ladate=new Date();
var dateDuJour = (ladate.getDate()+"-"+(ladate.getMonth()+1)+"-"+ladate.getFullYear());
var moisActuel = ((ladate.getMonth()+1)+"-"+ladate.getFullYear());
var anneeActuel = (ladate.getFullYear());

var xaxis = [];
var yaxis = [];

function affichageParDefaut(){
    xaxis = [];
    yaxis = [];
    for (let element=0; element<list.length; element++){
        yaxis.push(list[element][0]);
        xaxis.push(list[element][1]);
    };
    displayGraph();
}

affichageParDefaut();

document.getElementById("buttonDay").onclick = function () {
    xaxis = [];
    yaxis = [];
    for (let element=0; element<list.length; element++){
        if(dateDuJour == list[element][1]){
            yaxis.push(list[element][0]);
            xaxis.push(list[element][1]);
        }
    };
    displayGraph();
};

document.getElementById("buttonMonth").onclick = function () {
    xaxis = [];
    yaxis = [];
    for (let element=0; element<list.length; element++){
        if(list[element][1].endsWith(moisActuel)){
            yaxis.push(list[element][0]);
            xaxis.push(list[element][1]);
        }
    };
    displayGraph();
};

document.getElementById("buttonYear").onclick = function () {
    xaxis = [];
    yaxis = [];
    for (let element=0; element<list.length; element++){
        if(list[element][1].endsWith(anneeActuel)){
            yaxis.push(list[element][0]);
            xaxis.push(list[element][1]);
        }
    };
    displayGraph();
};

function displayGraph(){
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

displayGraph();
