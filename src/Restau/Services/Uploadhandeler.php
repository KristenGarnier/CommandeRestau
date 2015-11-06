<?php

namespace Restau\Services;

use Silex\Application;
use nwtn\Respimg;


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
            $this->optimize($path.$filename);
            return $filename;
        };

        $filename = $this->renameFile($tabFileName, 1, $path);
        $file->move($path,$filename);
        $this->optimize($path.$filename);


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

    private function optimize($imagePath)
    {

        chmod($imagePath, 0777);
        $image = new Respimg($imagePath);
        $width = getimagesize($imagePath);
        if ($width > 54) {
            $width = 54;
        }
        $image->smartResize($width, 0, true);
        $image->cropImage($width, $width, 0,0);
        $image->writeImage($imagePath);
        Respimg::optimize($imagePath, 0, 1, 1, 1);
    }

}