<?php

class Analyser{

    private $rows;
    private $teilnehmer;
    private $teilnehmerCount;
    private $teilnehmerBildCount;
    private $times;

    public function __construct($filepath){
        $this->rows = file($filepath);;
        $this->teilnehmer = array();
        $this->teilnehmerCount = array();
        $this->times = array();
    }

    public function analyse(){
        foreach ($this->rows as $row){
            $this->analyseRow($row);
        }
        $this->teilnehmerCount = $this->sortArray($this->teilnehmerCount);
        $this->teilnehmerBildCount = $this->sortArray($this->teilnehmerBildCount);
        $this->sortTimeArray();
    }

    private function sortTimeArray(){
        $new = array();
        for($i = 0; $i < 24; $i++){
            $index = "";
            if($i < 10){
                $index = "0" . $i;
            } else{
                $index = "" . $i;
            }
            $new[$index] = $this->times[$index];
        }
        $this->times = $new;
    }

    private function sortArray($arr){
        $new = array();
        foreach ($this->teilnehmer as $teilnehmer){
            $new[$teilnehmer] = $arr[$teilnehmer];
        }
        return $new;

    }

    private function addTeilnehmer($name, $istBild){
        if(!in_array($name, $this->teilnehmer)){
            $this->teilnehmer[] = $name;
			$this->teilnehmerCount[$name] = 0;
			$this->teilnehmerBildCount[$name] = 0;
        }
        $this->teilnehmerCount[$name] += 1;
        if($istBild){
            $this->teilnehmerBildCount[$name] += 1;
        }

    }

    private function returnKleinstenTreffer($treffer){
        $kleinsterIndex = 0;
        $length = strlen($treffer[0]);
        for($i = 1; $i < sizeof($treffer); $i++){
            if(strlen($treffer[$i]) < $length){
                $kleinsterIndex = $i;
                $length = strlen($treffer[$i]);
            }
        }
        return $treffer[$kleinsterIndex];

    }

    private function analyseRow($row){
        if(preg_match("/[0-9]{2}.[0-9]{2}.[0-9]{2},.[0-9]{2}:[0-9]{2}.-.*?:/", $row, $treffer)){
            $importantTreffer = $this->returnKleinstenTreffer($treffer);
            $name = substr($importantTreffer,18,-1);
            $zeit = substr($importantTreffer, 10, 2);
            if(preg_match("/<Medien weggelassen>/", $row)){
                $this->addTeilnehmer($name, true);
            } else{
                $this->addTeilnehmer($name, false);
            }
			
			if(!array_key_exists ($zeit, $this->times)){
				$this->times[$zeit] = 0;
			}
            $this->times[$zeit] += 1;
        }
    }

    private function createChartJson($col, $content){
        $data = array();

        $cols = array();
        $cols[] = ["id" => "","label" => $col[0],"pattern" => "","type" => "string"];
        $cols[] = ["id" => "","label" => $col[1],"pattern" => "","type" => "number"];

        $data["cols"] = $cols;

        $rows = array();
        foreach ($content as $key => $value){
            $firstColum = array();
            $firstColum["v"] = $key;
            $firstColum["f"] = null;

            $secondColum = array();
            $secondColum["v"] = $value;
            $secondColum["f"] = null;

            $row = [$firstColum, $secondColum];
            $arr = ["c" => $row];
            $rows[] = $arr;
        }

        $data["rows"] = $rows;
        return $data;
    }

    public function createJson($parm){
        $response = "";
        switch ($parm){
            case "chart1":
                $response = $this->createChartJson(["Teilnehmer","Anzahl"], $this->teilnehmerCount);
                break;
            case "chart2":
                $response = $this->createChartJson(["Teilnehmer","Anzahl"], $this->teilnehmerBildCount);
                break;
            case "chart3":
                $response = $this->createChartJson(["Zeit","Anzahl Nachrichten"], $this->times);
                break;
            case "gesamt":
                $response = $this->createGesamtStatJson();
                break;
        }
        return json_encode($response);
    }

    private function createGesamtStatJson(){
        $data = array();
        $data["countNachrichten"] = array_sum($this->teilnehmerCount);
        $data["countTeilnehmer"] = sizeof($this->teilnehmer);
        $data["countBilder"] = array_sum($this->teilnehmerBildCount);
        $data["countMaxNachrichten"] = max($this->times);
        $data["startTime"] = array_keys($this->times, max($this->times))[0];
        $data["endTime"] = $data["startTime"] + 1;

        return $data;
    }

}