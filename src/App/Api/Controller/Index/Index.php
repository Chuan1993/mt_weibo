<?php
namespace Mt\App\Api\Controller\Index;

use Mt\App\Api\Controller\Controller;
use Mt\Model\UserModel;

class Index extends Controller
{
    public function main()
    {
    	echo hi;
        $contentModel = UserModel::getInstance();
        var_dump($contentModel);
        exit();
    }

    public function getApp(){
    	echo 1;
    }
}