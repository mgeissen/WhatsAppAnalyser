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
        include "resources/html/header.php";
        if(file_exists("../../customHeader.php")){
            include_once "../../customHeader.php";
        }
    }

    private function includeChartScript(){
        ?>
        <script type="text/javascript" src="resources/js/stats.js"></script>
        <script type="text/javascript">
            document.stats.init({
                uploadFile: "<?= $this->uploadFile ?>",
                pieChart: [
                    "chart1",
                    "chart2",
                    "chartMessageSize"
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
                    "endTime",
                    "messageSizeAverage",
                    "messageSizeSum",
                    "bestDay",
                    "bestDayCount"
                ]
            });
            document.stats.drawCharts();
        </script>
        <?php
    }

    private function includeStylesheet(){
        ?>
        <link rel="stylesheet" href="resources/css/stylesheet.css">
        <?php
    }

    private function renderBody(){
        if(isset($_POST["submit"]) && strpos($this->uploadFile , "txt")){
            include_once "resources/html/stats.php";
            ?>
            <script>
                document.stats.drawStats();
            </script>
            <?php
        } else{
            include_once "resources/html/upload.php";
        }
        include_once "resources/html/footer.html";
    }
}