<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;

class GetHot extends Controller
{
    public function main()
    {
       
       $contentModel = ContentModel::getInstance();
       $list = $contentModel->getHottestContent();
       $this->outputJson('success', $list);
    }
}