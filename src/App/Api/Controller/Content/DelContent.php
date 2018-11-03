<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;


class DelContent extends Controller
{
	
    public function main()
    {
    	//获取当前用户id
        //$session = Session::getInstance();
        //$userId  = $session->get('uid');
        //获取动态内容
        $cId = $this->request->input('content_id');
    	
        $contentModel = ContentModel::getInstance();

        $result = $contentModel->deleteContent($cId);
        if ($result) {
            echo 'success';
        }else{
            echo 'failed';
        }
        
       	
        

    }
}