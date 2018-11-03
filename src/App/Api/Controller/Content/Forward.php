<?php
namespace Mt\App\Api\Controller\Content;

use Fw\App;
use Fw\Redis;
use Mt\App\Api\Controller\Controller;
use Mt\Model\ContentModel;
use Fw\Session;



class Forward extends Controller
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
        $transContentId = $this->request->input('content_id');
    	
        $uid = $this->uid;
        $data['content'] = $content;
        $data['uid'] = $uid;

        $contentModel = ContentModel::getInstance();

        $result = $contentModel->forward($transContentId,$data);
        if ($result) {
            echo 'success';
        }else{
            echo 'failed';
        }
        
       	
        

    }
}