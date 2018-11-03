<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;

class ContentDetail extends Controller
{
    public function main()
    {
       $cId = $this->request->input('content_id');
       $contentModel = ContentModel::getInstance();
       if (!is_array($cId)) {
       		$cId = [$cId];
       }
       $list = $contentModel->getListByIds($cId);
       $this->outputJson('success', $list);
    }
}