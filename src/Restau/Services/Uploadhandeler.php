<?php

namespace Restau\Services;

use Silex\Application;


/**
 * Class UploadHandler
 *
 * Help to upload an image to the server
 *
 * @package Restau\Services
 */
class Uploadhandeler
{

    private $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function uploadFile($file){
        $path = __DIR__.'/../../../public/uploads/';

        $filename = $file->getClientOriginalName();
        $tabFileName  = explode('.', $filename);
        if(!$this->fileExist($path.$filename)){
            $file->move($path,$filename);
            return $filename;
        };

        $filename = $this->renameFile($tabFileName, 1, $path);
        $file->move($path,$filename);


        return $filename;

    }

    private function fileExist($path){
        return file_exists($path);
    }

    private function renameFile($tabFileName, $i, $path){
        $tempName = $tabFileName[0].'_'.$i.'.'.$tabFileName[1];
        if(!$this->fileExist($path.$tempName)){
            return $tempName;
        }

        $i++;
        return $this->renameFile($tabFileName, $i, $path);
    }

}