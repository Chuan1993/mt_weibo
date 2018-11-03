<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;

class GetLatest extends Controller
{
    public function main()
    {
       
       $contentModel = ContentModel::getInstance();
       $list = $contentModel->getLastContent();
       $this->outputJson('success', $list);
    }
}