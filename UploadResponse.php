<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 29.09.17
 * Time: 16:59
 */

class UploadResponse{

    private $status;
    private $filePath;

    private $failedText;

    private function __construct(){
        // use static builder funtion
        $this->failedText = "";
    }

    public static function ofFail($failureText = ""): UploadResponse{
        $response = new self();
        $response->setStatus(false);
        $response->failedText = $failureText;
        return $response;
    }

    public static function ofSuccess($filePath): UploadResponse{
        if($filePath == null || $filePath == ""){
            return UploadResponse::ofFail("The file path is not specified.");
        }
        $response = new self();
        $response->setStatus(true);
        $response->setFilePath($filePath);
        return $response;
    }

    private function setStatus($status){
        $this->status = $status;
    }

    private function setFilePath($filePath){
        $this->filePath = $filePath;
    }

    public function isUploaded(): bool {
        return $this->status;
    }

    public function getFilePath(): string{
        return $this->filePath;
    }

    public function getFailedText(): string{
        return $this->failedText;
    }
}