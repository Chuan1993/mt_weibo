<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;

//展示最热动态
class Index extends Controller
{
    public function main()
    {
        //$redis = Redis::getInstance(App::getInstance()->env('redis.default'));
        //var_dump($redis->hGetAlls('test'));s
        echo getIP();
       
    }
}

