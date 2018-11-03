<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;
use Fw\Session;


class DeliveryContent extends Controller
{
	/*	生成动态需要用户id，动态id，动态id生成规则：
	 *   contentId = baseContentId*3 + uid%3.
	 */
    
    public function main()
    {
    	//获取当前用户id
        //$session = Session::getInstance();
        //$userId  = $session->get('uid');
        //获取动态内容

        $content = $this->request->input('content');
        $uid = $this->uid;

    	
        $data['uid'] = $uid;
        $data['content'] = $content;
        $contentModel = ContentModel::getInstance();

        $result = $contentModel->insertContent($data);
        if ($result) {
            echo 'success';
        }else{
            echo 'failed';
        }
        
       	
        

    }
}