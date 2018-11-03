<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;

class EditContent extends Controller
{
    public function main()
    {
       $cId = $this->request->input('content_id');
       $content = $this->request->input('content');
       $contentModel = ContentModel::getInstance();
       
       $result = $contentModel->editContent($cId,$content);
       if ($result) {
        echo 'success';
      }else{
        echo 'failed';
      }
    }
}