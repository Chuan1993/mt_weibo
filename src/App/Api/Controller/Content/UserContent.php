<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;

class UserContent extends Controller
{
    public function main()
    {
       $uid = $this->uid;
       $contentModel = ContentModel::getInstance();
       $list = $contentModel->getUserContent($uId);

       $this->outputJson('success', $list);
    }
}