<?php
include_once "UploadResponse.php";
class Frontend{

    private $uploadFile;

    public function __construct(){
        $response = $this->handleUpload();
        if($response->isUploaded()){
            $this->uploadFile = $response->getFilePath();
        } else{
            $this->uploadFile = "";
        }
    }

    public function start(){
        $this->renderHead();
        $this->includeChartScript();
        $this->includeStylesheet();
        $this->renderBody();
    }

    function handleUpload(): UploadResponse{
        if(!isset($_FILES["fileupload"])){
            return UploadResponse::ofFail();
        }
        $target_dir = "./tmp/";
        //$target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
        $target_file = $target_dir . "1.txt";
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if ($_FILES["fileupload"]["size"] > 5000000) {
            return UploadResponse::ofFail("File size over 5 mb.");
        }
        if($imageFileType != "txt"){
            return UploadResponse::ofFail("Please Upload File with .txt extension.");
        }
        $fileName = $target_dir . time() . ".txt";
        if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $fileName)) {
            return UploadResponse::ofSuccess($fileName);
        }
        return UploadResponse::ofFail("The File cant uploaded, perhaps you have no permission to write file in 'tmp' folder.");
    }

    private function renderHead(){
        ?>
        <head>
            <!-- Bootstrap-->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

            <!--Load the AJAX API-->
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        </head>
        <?php
    }

    private function includeChartScript(){
        ?>
        <script type="text/javascript">
            // Load the Visualization API and the piechart package.
            google.charts.load('current', {'packages':['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart("chart1"));
            google.charts.setOnLoadCallback(drawChart("chart2"));
            google.charts.setOnLoadCallback(drawColumnChart("chart3"));

            function getUrl(type){
                var url = "data.php?";
                var typeParm = "type=" + type;
                var fileParm = "file=" + "<?= $this->uploadFile ?>";
                return url + typeParm + "&" + fileParm;
            }

            function drawChart(type) {
                return function () {
                    var jsonData = $.ajax({
                        url: getUrl(type),
                        dataType: "json",
                        async: false
                    }).responseText;

                    // Create our data table out of JSON data loaded from server.
                    var data = new google.visualization.DataTable(jsonData);

                    // Instantiate and draw our chart, passing in some options.
                    var chart = new google.visualization.PieChart(document.getElementById(type));
                    chart.draw(data, {width: 400, height: 240});
                }
            }

            function drawColumnChart(type){
                return function(){
                    var jsonData = $.ajax({
                        url: getUrl(type),
                        dataType: "json",
                        async: false
                    }).responseText;

                    var data = new google.visualization.DataTable(jsonData);
                    var options = {};

                    var chart = new google.visualization.ColumnChart(document.getElementById(type));

                    chart.draw(data, {width: 1000, height: 240});
                }
            }

            function setGesamtStat(){
                var jsonGesamt = JSON.parse($.ajax({
                    url: getUrl("gesamt"),
                    dataType: "json",
                    async: false
                }).responseText);
                document.getElementById("countNachrichten").innerHTML = jsonGesamt.countNachrichten;
                document.getElementById("countTeilnehmer").innerHTML = jsonGesamt.countTeilnehmer;
                document.getElementById("countBilder").innerHTML = jsonGesamt.countBilder;

                document.getElementById("countMaxNachrichten").innerHTML = jsonGesamt.countMaxNachrichten;
                document.getElementById("startTime").innerHTML = jsonGesamt.timeMaxNachrichten;
                document.getElementById("endTime").innerHTML = parseInt(jsonGesamt.timeMaxNachrichten) + 1;
            }

        </script>
        <?php
    }

    private function includeStylesheet(){
        ?>
        <style>
            .floatLeft{
                float: left;
            }
        </style>
        <?php
    }

    private function renderBody(){
        $this->renderBodyHeader();
        if(isset($_POST["submit"]) && strpos($this->uploadFile , "txt")){
            $this->renderStatsPage();
        } else{
            $this->renderUploadPage();
        }
        $this->renderBodyFooter();
    }

    private function renderStatsPage(){
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Gesamt Statistik</h3>
            </div>
            <div class="panel-body">
                <div><span class="glyphicon glyphicon-send"></span> <span id="countNachrichten"></span> Nachrichten davon <span class="glyphicon glyphicon-picture"></span> <span id="countBilder"></span> Medien</div>
                <div><span class="glyphicon glyphicon-user"></span> <span id="countTeilnehmer"></span> Teilnehmer</div>
                <div><span class="glyphicon glyphicon-time"></span> Zwischen <span id="startTime"></span> und <span id="endTime"></span> Uhr schreibt ihr am öftesten, insgesamt <span class="glyphicon glyphicon-send"></span> <span id="countMaxNachrichten"></span> Nachrichten</div>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Nachrichten Verteilung auf Teilnehmer</h3>
            </div>
            <div class="panel-body">
                <div class="floatLeft">
                    <h4>Nachrichten Verteilung</h4>
                    <div id="chart1"></div>
                </div>
                <div class="floatLeft">
                    <h4>Medien Verteilung</h4>
                    <div id="chart2"></div>
                </div>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Zeitverteilung der Nachrichten</h3>
            </div>
            <div class="panel-body">
                <div class="floatLeft">
                    <div id="chart3"></div>
                </div>
            </div>
        </div>
        <script>
            setGesamtStat();
        </script>
        <?php
    }

    private function renderBodyHeader(){
        ?>
        <body>
        <div class="container center">
            <h1>WhatsApp Analyser</h1>
        <?php
    }

    private function renderBodyFooter(){
        ?>
        </div>
        </body>
        </html>
        <?php
    }

    private function renderUploadPage(){
        ?>
        <form method="post" enctype="multipart/form-data">
            Wähle eine WhatsApp .txt Datei aus:
            <input type="file" name="fileupload" id="fileupload">
            <input type="submit" value="Upload .txt" name="submit">
        </form>
        <?php
    }


}