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
        $file->move($path,$filename);

        return $filename;
    }

}