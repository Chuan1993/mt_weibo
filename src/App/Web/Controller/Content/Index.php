<?php
namespace Mt\App\Web\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Web\Controller\Controller;
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
