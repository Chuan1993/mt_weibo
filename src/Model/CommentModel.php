<?php
/**
 * Created by PhpStorm.
 * User: zh11@meitu.com
 * Date: 2018/9/3
 * Time: 下午6:59
 * Description:
 */

namespace Mt\Model;

use Fw\App;
use Fw\TableTrait;
use Fw\Redis;

class CommentModel extends Model
{
    use TableTrait {
        getOne as private _getOne;
        insert as private _insert;
        update as private _update;
    }

    protected $tablePrefix = 'weibo_comment0';

    const BASE_COMMENT_ID = 'BASE_COMMENT_ID';//存放redis中UID自增的键值   默认100000000
    const REDIS_CONFIG = 'redis.default';//redis配置
    const TABLE_NUMBER = 3;//分表数量

    //评论状态
    const STATUS_NORMAL = 0;
    const STATUS_DELETE = 1;

    private $statusMap = array(
        self::STATUS_NORMAL => '正常',
        self::STATUS_DELETE => '已删除'
    );

    function __construct()
    {
        $this->dbGroup = DB_GROUP_MAIN;
        $this->primaryKey = 'comment_id';
    }

    public function getTable($content_id)
    {
        $tableName = $this->tablePrefix . ($content_id % self::TABLE_NUMBER);
        return $tableName;
    }

    public function getOneByOption($content_id,$option)
    {
        $_db = $this->db()->select()->from($this->getTable($content_id));

        foreach ($option as $k => $v)
        {
            $_db = $_db->where($k,$v);
        }

        return  $_db->fetch();
    }

    public function getCommentsByContent($content_id,$start,$count)
    {
        $_db = $this->db()->select()->from($this->getTable($content_id));
        $_db = $_db->where('content_id', $content_id)->where('is_deleted',self::STATUS_NORMAL);

        return $_db->orderBy('created_at','ASC')->offset($start)->limit($count)->fetchAll();
    }

    /**
     * 插入成功后对键值自增
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        $redis = Redis::getInstance(App::getInstance()->env(self::REDIS_CONFIG));
        $data[$this->primaryKey] = !empty($data[$this->primaryKey]) ? $data[$this->primaryKey] : ((int)$redis->get(self::BASE_COMMENT_ID) + $data['content_id'] % 3);
        $data['created_at'] = !empty($data['created_at']) ? $data['created_at'] : NOW_DATE;

        $tableName = $this->getTable($data['content_id']);
        $result = $this->db()->insert($tableName,$data)->exec();
        if ($result) {
            $redis->incr(self::BASE_COMMENT_ID);
        }

        return $result;
    }

    public function update($content_id,$comment_id,$data)
    {
        $tableName = $this->getTable($content_id);

        if (!$this->db()->update($tableName,$data)->where($this->primaryKey,$comment_id)->exec())
        {
            return false;
        }
        return true;
    }


    /**
     * 评论作者删除自己的评论
     *
     * @param $uid
     * @param $comment_id
     * @param $content_id
     * @author zh11@meitu.com
     * @return bool
     */
    public function deleteByOwner($uid,$content_id,$comment_id)
    {
        //保证是作者本人才能删除
        $comment = $this->getOneByOption($content_id,['uid' => $uid,'comment_id' => $comment_id]);

        if (!$comment)
        {
            return false;
        }

        if (!$this->update($content_id,$comment_id,['is_deleted' => self::STATUS_DELETE]))
        {
            return false;
        }
        return true;
    }

    public function handleOption($_db, $option)
    {
        if (!empty($option) && is_array($option)) {
            foreach ($option as $k => $v) {
                    $_db->where($k, $v);
            }
        }

        return $_db;
    }


}