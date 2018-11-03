<?php
/**
 * Created by PhpStorm.
 * User: zh11@meitu.com
 * Date: 2018/9/7
 * Time: 下午3:57
 * Description:
 */
namespace Mt\App\Api\Controller\Comment;

use Mt\App\Api\Controller\Controller;
use Mt\Model\CommentModel;
use Mt\Model\ContentModel;

class DeleteComment extends Controller
{

    public function main()
    {
        //参数验证
        $params = $this->request->get();

        $uid = $this->uid;

        if (empty($params['content_id']) || !is_int((int)$params['content_id']))
        {
            $this->outputJson('content_id_invalid');
        }

        if (empty($params['comment_id']) || !is_int((int)$params['comment_id']))
        {
            $this->outputJson('comment_id_is_empty');
        }

        //该评论的动态是否还存在
        $contentModel = ContentModel::getInstance();
        $content = $contentModel->getOneByOption([],$params['content_id']);

        if (empty($content))
        {
            $this->outputJson('content_not_exist');
        }

        $commentModel = CommentModel::getInstance();

        if ($commentModel->deleteByOwner($uid,$params['content_id'],$params['comment_id'])){
            $this->outputJson('success');
        }else{
            $this->outputJson('comment_delete_failed');
        }
    }
}