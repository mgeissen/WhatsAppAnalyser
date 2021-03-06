document.stats = function () {
    var args = {};
    //args.uploadFile;
    //args.pieChart = [];
    //args.columnChart = [];
    //args.simpleStats = [];


    var getUrl = function (type) {
        var url = "analyser/?";
        var typeParm = "type=" + type;
        var fileParm = "file=" + args.uploadFile;
        var urlWithParms = url + typeParm + "&" + fileParm;
        return urlWithParms;
    };

    var getPieChartCallback = function (elementId) {
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
    };

    var getColumnChartCallback = function (elementId) {
        return function () {
            var jsonData = $.ajax({
                url: getUrl(elementId),
                dataType: "json",
                async: false
            }).responseText;

            var data = new google.visualization.DataTable(jsonData);

            var chart = new google.visualization.ColumnChart(document.getElementById(elementId));
            chart.draw(data, {width: 1000, height: 240});
        }
    };

    return {
        init: function (initArgs) {
            google.charts.load('current', {'packages': ['corechart']});
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
            var jsonGesamt = JSON.parse($.ajax({
                url: getUrl("gesamt"),
                dataType: "json",
                async: false
            }).responseText);

            args.simpleStats.forEach(function (element) {
                document.getElementById(element).innerHTML = jsonGesamt[element];
            })
        }
    };
}();