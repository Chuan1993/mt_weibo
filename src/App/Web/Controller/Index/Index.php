<?php
namespace Mt\App\Web\Controller\Index;

use Fw\App;
use Fw\Redis;
use Mt\App\Web\Controller\Controller;
use Mt\Model\UserModel;
use Mt\Model\ContentModel;

class Index extends Controller
{
    public function main()
    {
        //$redis = Redis::getInstance(App::getInstance()->env('redis.default'));
        //var_dump($redis->hGetAll('test'));
        $params = [
            'uid' => '100000000',
            'password' => '123456',
            'client_id' => CLIENT_WEB_ID
        ];
        //echo setParams($params);

        $content = UserModel::getInstance();
        var_dump($content);
        //$content->getLatestContent();

        //echo base64_encode(json_encode($params));
    }
}