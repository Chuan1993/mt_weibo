<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;

class UserLatest extends Controller
{
    public function main()
    {
       $uid = $this->uid;
       $contentModel = ContentModel::getInstance();
       $result = $contentModel->getLatestForUser($uId);
       $this->outputJson('success', $result);
    }
}