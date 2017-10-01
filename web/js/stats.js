var Stats = Stats || (function () {
    var args = {};
    //args.uploadFile;
    //args.pieChart = [];
    //args.columnChart = [];
    //args.simpleStats = [];


    function getUrl(type) {
        var url = "analyser/?";
        var typeParm = "type=" + type;
        var fileParm = "file=" + args.uploadFile;
        var urlWithParms = url + typeParm + "&" + fileParm;
        return urlWithParms;
    }

    function getPieChartCallback(elementId) {
        return function () {
            var jsonData = $.ajax({
                url: getUrl(elementId),
                dataType: "json",
                async: false
            }).responseText;

            var data = new google.visualization.DataTable(jsonData);

            var chart = new google.visualization.PieChart(document.getElementById(elementId));
            chart.draw(data, {width: 350, height: 240});
        }
    }

    function getColumnChartCallback(elementId){
        return function(){
            var jsonData = $.ajax({
                url: getUrl(elementId),
                dataType: "json",
                async: false
            }).responseText;

            var data = new google.visualization.DataTable(jsonData);

            var chart = new google.visualization.ColumnChart(document.getElementById(elementId));
            chart.draw(data, {width: 1000, height: 240});
        }
    }

    return {
        init: function(initArgs){
            google.charts.load('current', {'packages':['corechart']});
            args = initArgs;
        },
        drawCharts: function () {
            args.pieChart.forEach(function (element) {
                google.charts.setOnLoadCallback(getPieChartCallback(element));
            });
            args.columnChart.forEach(function (element) {
                google.charts.setOnLoadCallback(getColumnChartCallback(element));
            });
        },
        drawStats: function () {
            console.log(getUrl("gesamt"));
            var jsonGesamt = JSON.parse($.ajax({
                url: getUrl("gesamt"),
                dataType: "json",
                async: false
            }).responseText);

            args.simpleStats.forEach(function (element) {
                document.getElementById(element).innerHTML = jsonGesamt[element];
            })
        }
    }
});