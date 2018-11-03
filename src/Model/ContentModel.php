<?php
/**
 * Message: 动态类    注意：contentID = baseId * 3 + uid % 3
 * User: yzc<yzc2@meitu.com>
 * Date: 201809
 * Time: 21:18
 * Return:
 */

namespace Mt\Model;

use Fw\App;
use Fw\TableTrait;
use Fw\Redis;

class ContentModel extends Model
{
    use TableTrait {
        getOne as private _getOne;
        insert as private _insert;
        update as private _update;
    }

    protected $tablePrefix = 'weibo_content0';

    const REDIS_CONFIG = 'redis.default';//redis配置
    const TABLE_NUMBER = 3;//分表数量

    //动态信息状态
    const STATUS_NORMAL = 1;
    const STATUS_DELETED = 2;

    //动态是否转发
    const CONTENT_TRANSE_YSE = 1;
    const CONTENT_TRANSE_NO = 0;

    //动态热度，默认100,转发+10，评论+10，举报-10，etc..
    const BASE_HOT = 100;

    public $statusMap = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_DELETED => '删除'
    ];

    public $redis;
    public $time;
    public $date;

    const BASE_CONTENT_ID   = 'BASE_CONTENT_ID';    //动态ID生成基础ID
    const LAST_LIST         = 'LAST_LIST';          // 最新动态列表
    const HOTTEST_LIST      = 'HOTTEST_LIST';       // 最热动态列表
    const SCANNER_USER      = 'SCANNER_USER';       // 用户已读列表
    const HOTTEST_LIST_USER = 'HOTTEST_LIST_USER';  // 用户最热动态列表
    const LAST_LIST_USER    = 'LAST_LIST_USER';     // 用户最新动态列表


    function __construct()
    {
        $this->dbGroup = DB_GROUP_MAIN;
        $this->primaryKey = 'content_id';
        $this->redis = Redis::getInstance(App::getInstance()->env(self::REDIS_CONFIG));
        $this->time = time();
        $this->date = date("Ymd");
    }

    /**
     * @desc 获取动态表格
     *
     * @param int $contentId 动态id的主键信息
     * @access public
     * @return string 
     */
    public function getTable($contentId = 0)
    {
        $contentId = $contentId ? : $this->redis->get(self::BASE_CONTENT_ID);

        return $this->tablePrefix . (intval($contentId) % self::TABLE_NUMBER);
    }
    /**
     * @desc 从数据库中取出一条动态
     *
     * @param $option array  查询条件
     * @param $contentId int 动态id的主键信息
     * @access public
     * @return array
     */

    public function getOneByOption($option, $contentId = 0)
    {
        $_db = $this->db()->select()->from($this->getTable($contentId));

        $_db = $this->handleOption($_db, $option);

        return  $_db->fetch();
    }

    /**
     * 注意：ID数组必须在同一张表，不然无法找到
     * @param $ids
     * @param int $tableSuffix
     * @return mixed
     */
    public function getListByIds($ids, $tableSuffix = 0)
    {
        $_db = $this->db()->select()->from($this->getTable($tableSuffix));

        $_db->where($this->primaryKey, $ids, 'IN');

        return  $_db->fetchAll();
    }

    /**
     * @desc 选取条件
     * @param 
     * @return mixed
     */

    public function handleOption($_db, $option)
    {
        if (!empty($option) && is_array($option)) {
            foreach ($option as $k => $v) {
                $_db->where($k, $v);
            }
        }

        return $_db;
    }

    /**
     * 动态ID生成规则   contentID = baseId * 3 + uid % 3
     * @desc 生成一条动态
     * @param $data array 内容
     * @return mixed
     */
    public function insertContent($data)
    {
        if (empty($data['content'])) {
            return false;
        }
        $contentId = intval($this->redis->get(self::BASE_CONTENT_ID)) * 3 + $data['uid'] % 3;

        $data['is_trans'] = $data['is_trans'] ? self::CONTENT_TRANSE_YSE : self::CONTENT_TRANSE_NO;
        $data['content_id'] = $contentId;
        $data['created_at'] = !empty($data['created_at']) ? $data['created_at'] : NOW_DATE;
        $result = $this->db()->insert($this->getTable($contentId), $data)->exec();
        //数据库插入成功，维护最新最热动态表,insert操作返回当前主键id
        if ($result) {
            // 插入有序集合，成功则自增ID
            $this->redis->zAdd(self::HOTTEST_LIST.$this->date, self::BASE_HOT, $contentId);
            $this->redis->zAdd(self::LAST_LIST.$this->date, $this->time , $contentId);
            $this->redis->incr(self::BASE_CONTENT_ID);
            return true;
        }

        return false;
    }

     /**
     * @desc 删除一条动态
     * @param $contentId string 内容
     * @return mixed
     */
    public function deleteContent($contentId)
    {   
        $cIds = [$contentId];
        $contentInfo = $this->getListByIds($cIds);
        $date = $contentInfo[0]['created_at'];
        $time = strtotime($date);
        $date = date("Ymd" , $time);

        
        $data['is_deleted'] = 1;
        
        $this->db()->update($this->getTable($contentId), $data);
        $result = $this->db()->where($this->primaryKey, $contentId)->exec();

        
        //更新成功，清除缓存
        if ($result) {
            $this->redis->zRem(self::HOTTEST_LIST.$date, $contentId);
            $this->redis->zRem(self::LAST_LIST.$date, $contentId);
            return true;
        }

        return false;
    }

    /**
     * 由于不同ID落在不同表，因此需要区分处理
     * @param $ids
     * @return array
     */
    public function dealIds($ids) {
        //先对获取的ID分类,然后批量查询
        $temp = array();
        if (!empty($ids)) {
            foreach ($ids as $k) {
                switch (intval($k) % 3) {
                    case 0:
                        $temp[0][] = $k;
                        break;
                    case 1:
                        $temp[1][] = $k;
                        break;
                    case 2:
                        $temp[2][] = $k;
                        break;
                }
            }
        }

        $result = array();
        foreach ($temp as $k => $v) {
            $result = array_merge($result, $this->getListByIds($v, $k));
        }

        return $result;
    }

     /**
     * @desc 获取最新的动态
     * @param $start,起始成员位置，0为第一个
     * @param $end ,最后成员位置，-1为最后一个
     * @return array
     */
    public function getLastContent($start = 0, $end = 20 , $day = 1)
    {
        $lastList = $this->redis->zRevRange(self::LAST_LIST.$this->date, $start, $end);

        return $this->dealIds($lastList);
    }

    /**
     * @desc 获取最火的动态
     * @param $start,int 起始位置
     * @param $end ,int 结束位置
     * @return array
     */
    public function getHottestContent($start = 0 , $end = 20 , $day = 1)
    {
        // 获取  ID => 热度 数组
        $hottestList = $this->redis->zRevRange(self::HOTTEST_LIST.$this->date, $start, $end , true);

        $result = $this->dealIds(array_keys($hottestList));
        //  加上热度信息
        foreach ($result as &$_result) {
            $_result['hot_score'] = $hottestList[$_result['content_id']];
        }

        return $result;
    }

    /**
     * @desc 点赞功能
     * @param $contentId
     * @return bool
     */

    public function praiseContent($contentId)
    {
        $cIds = [$contentId];
        $contentInfo = $this->getListByIds($cIds);
        $date = $contentInfo[0]['created_at'];
        $time = strtotime($date);
        $date = date("Ymd" , $time);
        $result = $this->redis->zIncrBy(self::HOTTEST_LIST.$date, 10 , $contentId);
        return $result;

    }
    /**
     * @desc 编辑动态
     * @param $contentId int 编辑动态ID
     * @param $content ,string 编辑内容
     * @return array
     */
    public function editContent($contentId,$content)
    {
        //更新数据库
        $data['content'] = $content;
        $data['updated_at'] = NOW_DATE;
        
        $this->db()->update($this->getTable($contentId), $data);
        $result = $this->db()->where($this->primaryKey, $contentId)->exec();
        return $result;
    }

    /**
     * @desc 获取用户动态
     * @param $uid ,int 用户id
     * @return array
     */

    public function getUserContent($uid)
    {
       
        return $this->db()->select()->from($this->getTable($uid))->where('uid', $uid)->fetchAll();
    }

    /**
     * @desc 转发动态
     * @param $transContentId  int 转发的id
     * @param $data array
     * @return bool
     */

    public function forward($transContentId,$data)
    {
        if (empty($data['content'])) {
            return false;
        }
        $contentId = intval($this->redis->get(self::BASE_CONTENT_ID)) * 3 + $data['uid'] % 3;

        $data['is_trans']  = self::CONTENT_TRANSE_YSE;
        $data['content_id'] = $contentId;
        $data['trans_id'] = $transContentId;

        $data['created_at'] = !empty($data['created_at']) ? $data['created_at'] : NOW_DATE;
        $result = $this->db()->insert($this->getTable($contentId), $data)->exec();
        //数据库插入成功，维护最新最热动态表,insert操作返回当前主键id
        if ($result) {
            // 插入有序集合，成功则自增ID
            $this->redis->zAdd(self::HOTTEST_LIST.$this->date, self::BASE_HOT, $contentId);
            $this->redis->zAdd(self::LAST_LIST.$this->date, $this->time , $contentId);
            $this->redis->incr(self::BASE_CONTENT_ID);
            return true;
        }

        return false;
    }
    /**
     * @desc 用户查看动态，将看过的存在缓存中
     * @param $uid  
     * @param $cId
     * @return bool
     */

    public function scanner($uid,$cId)
    {
        return $this->redis->sadd(self::SCANNER_USER."_".$uid."_".$this->date,$cId);

    }

    /**
     * @desc 针对用户推送最热，去掉读过的
     * @param $uid   int 
     * @param $start int 
     * @param $end   int
     * @param $day   int  设置过滤掉用户看过的天数
     * @return mixed
     */

    public function getHotForUser($uid , $start = 0 , $end = 20, $day = 0)
    {
        //取出最热动态
        $hottestList = $this->redis->zRevRange(self::HOTTEST_LIST.$this->date, $start, $end , true);

        //默认当天
        $userScanner = $this->redis->smembers(self::SCANNER_USER."_".$uid."_".$this->date);


        //如果有添加多天阅读，则需要循环
        if ($day) {
            $dayStr = sprintf('-%d days' , $day);
            $time = strtotime($dayStr);
        }

        foreach ($hottestList as $key => $value) {
            if (in_array($key,$userScanner) ) {
                unset($hottestList[$key]);
            }
        }
        $result = $this->dealIds(array_keys($hottestList));

        return $result;
        
    }

    /**
     * @desc 针对用户推送最新，去掉读过的
     * @param $uid   int 
     * @param $start int 
     * @param $end   int
     * @param $day   int  设置过滤掉用户看过的天数
     * @return mixed
     */

    public function getLatestForUser($uid , $start = 0 , $end = 20, $day = 0)
    {
       
        //取出最热动态
        $hottestList = $this->redis->zRevRange(self::LAST_LIST.$this->date, $start, $end , true);

        //默认当天
        $userScanner = $this->redis->smembers(self::SCANNER_USER."_".$uid."_".$this->date);


        //如果有添加多天阅读，则需要循环
        if ($day) {
            $dayStr = sprintf('-%d days' , $day);
            $time = strtotime($dayStr);
        }

        foreach ($hottestList as $key => $value) {
            if (in_array($key,$userScanner) ) {
                unset($hottestList[$key]);
            }
        }
        $result = $this->dealIds(array_keys($hottestList));



        return $result;
    }
/*
    


   


    
*/
}