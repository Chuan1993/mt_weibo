<?php
/**
 * Created by PhpStorm.
 * User: zh11@meitu.com
 * Date: 2018/9/7
 * Time: 下午5:36
 * Description:
 */

namespace Mt\App\Api\Controller\Comment;

use Mt\App\Api\Controller\Controller;
use Mt\Model\CommentModel;
use Mt\Model\ContentModel;

class GetCommentList extends Controller
{

    public function main()
    {
        $params = $this->request->get();

        if (empty($params['content_id']) || !is_int((int)$params['content_id']))
        {
            $this->outputJson('content_id_is_empty');
        }

        //该评论的动态是否还存在
        $contentModel = ContentModel::getInstance();
        $content = $contentModel->getOneByOption([],$params['content_id']);

        if (empty($content))
        {
            $this->outputJson('content_not_exist');
        }

        //获取起始
        empty($params['start'])?:$params['start'] = 0;
        //获取数量
        empty($params['count'])? :$params['count'] = 10;

        $commentModel = CommentModel::getInstance();
        $result = $commentModel->getCommentsByContent($params['content_id'],$params['start'],$params['count']);
        $res = array();

        foreach ($result as $k=>$v)
        {
            $res[] = array(
                'to_uid' => $v['to_uid'],
                'comment' => $v['comment']
            );
        }

        $this->outputJson('success',$res);

    }
}