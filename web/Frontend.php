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
        include "header.php";
    }

    private function includeChartScript(){
        ?>
        <script type="text/javascript" src="stats.js"></script>
        <script type="text/javascript">
            var stats = Stats();
            stats.init({
                uploadFile: "<?= $this->uploadFile ?>",
                pieChart: [
                    "chart1",
                    "chart2"
                ],
                columnChart: [
                    "chart3"
                ],
                simpleStats: [
                    "countNachrichten",
                    "countTeilnehmer",
                    "countBilder",
                    "countMaxNachrichten",
                    "startTime",
                    "endTime"
                ]
            });
            stats.drawCharts();
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
                <div>
                    <span class="glyphicon glyphicon-send"></span> <span id="countNachrichten"></span> Nachrichten davon <span class="glyphicon glyphicon-picture"></span> <span id="countBilder"></span> Medien</div>
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
            stats.drawStats();
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