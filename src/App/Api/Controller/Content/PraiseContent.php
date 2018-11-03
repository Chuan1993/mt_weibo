<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;

class PraiseContent extends Controller
{
    public function main()
    {
       $cId = $this->request->input('content_id');
       $contentModel = ContentModel::getInstance();
       $result = $contentModel->praiseContent($cId);

      if ($result) {
        echo 'success';
      }else{
        echo 'failed';
      }

       
    }
}