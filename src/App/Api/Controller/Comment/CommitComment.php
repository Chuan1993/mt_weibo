<?php
/**
 * Created by PhpStorm.
 * User: zh11@meitu.com
 * Date: 2018/9/4
 * Time: 下午8:52
 * Description:提交评论接口
 */
namespace Mt\App\Api\Controller\Comment;

use Fw\Session;
use Mt\App\Api\Controller\Controller;
use Mt\Model\CommentModel;
use Mt\Model\ContentModel;

class CommitComment extends Controller
{

    public function main()
    {
        //参数验证
        $params = $this->request->get();

        $uid = $this->uid;

        if (!empty($params['to_uid']) && !is_int((int)$params['to_uid']))
        {
            $this->outputJson('uid_invalid');
        }

        if (empty($params['content_id']) || !is_int((int)$params['content_id']))
        {
            $this->outputJson('content_id_invalid');
        }

        if (empty($params['comment']))
        {
            $this->outputJson('comment_is_empty');
        }

        //评论的动态是否还存在
        $contentModel = ContentModel::getInstance();
        $content = $contentModel->getOneByOption([],$params['content_id']);

        if (empty($content))
        {
            $this->outputJson('content_not_exist');
        }

        //获取评论人

        $commentModel = CommentModel::getInstance();

        $insertData = array(
            'uid' => $uid,
            'content_id' => $params['content_id'],
            'comment' => $params['comment']
        );

        if (!empty($params['to_uid']))
        {
            $insertData['to_uid'] = $params['to_uid'];
        }

        $res = $commentModel->insert($insertData);

        if (!$res)
        {
            $this->outputJson('comment_commit_failed');
        }else{
            $this->outputJson('success');
        }
    }
}