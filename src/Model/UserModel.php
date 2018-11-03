<?php
/**
 * Message: 用户类
 * User: jzc<jzc1@meitu.com>
 * Date: 2018/8/31
 * Time: 上午9:59
 * Return:
 */

namespace Mt\Model;

use Fw\App;
use Fw\TableTrait;
use Fw\Redis;
use Fw\Session;

class UserModel extends Model
{
    use TableTrait {
        getOne as private _getOne;
        insert as private _insert;
        update as private _update;
    }

    protected $tablePrefix = 'weibo_user0';

    const BASE_USER_ID = 'BASE_USER_ID';//存放redis中UID自增的键值   默认100000000
    const REDIS_CONFIG = 'redis.default';//redis配置
    const MAX_LOGIN_TIME = 60 * 60 * 24;//最长保持登录时间为一天
    const TABLE_NUMBER = 3;//分表数量
    public $redis;

    const SESSION_UID = 'SESSION_UID';

    //用户状态
    const STATUS_NORMAL = 1;
    const STATUS_BANNED = 2;
    const STATUS_DELETED = 3;

    public $statusMap = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_BANNED => '封禁',
        self::STATUS_DELETED => '已删除'
    ];


    function __construct()
    {
        $this->dbGroup = DB_GROUP_MAIN;
        $this->primaryKey = 'uid';
        $this->redis = Redis::getInstance(App::getInstance()->env(self::REDIS_CONFIG));
    }

    public function getTable($uid = 0)
    {
        $uid = $uid ? : $this->redis->get(self::BASE_USER_ID);
        return $this->tablePrefix . ($uid % self::TABLE_NUMBER);

    }

    public function getOneByOption($option, $uid = 0)
    {
        $_db = $this->db()->select()->from($this->getTable($uid));

        $_db = $this->handleOption($_db, $option);

        return  $_db->fetch();
    }

    /**
     * 插入成功后对键值自增
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        $data['uid'] = !empty($data['uid']) ? $data['uid'] : $this->redis->get(self::BASE_USER_ID);
        $data['created_at'] = !empty($data['created_at']) ? $data['created_at'] : NOW_DATE;

        $result = $this->db()->insert($this->getTable(), $data)->exec();
        if ($result) {
            $this->redis->incr(self::BASE_USER_ID);
            return $data['uid'];
        }

        return false;
    }

    public function handleOption($_db, $option)
    {
        if (!empty($option) && is_array($option)) {
            foreach ($option as $k => $v) {
                if ($k == 'password') {
                    $_db->where($k, setPassword($v));
                } else {
                    $_db->where($k, $v);
                }

            }
        }

        return $_db;
    }

    /**
     * 判断是否登录，是则返回登录信息，否则返回false
     * @param $uid
     * @return array|bool
     */
    public function getLoginStatus($uid)
    {
        if (!$this->redis->exists($uid)) {
            return false;
        }

        $login_status = $this->redis->hGetAll($uid);
        if (empty($login_status)) {
            return false;
        }

        $login_status['uid'] = $uid;
        return $login_status;
    }

    /**
     * 若已登录，则需要先删除原有状态才能重设登录状态
     * @param $uid
     * @param $info
     * @return bool
     */
    public function setLoginStatus($uid, $info)
    {
        if ($this->getLoginStatus($uid)) {
            return false;
        } else {
            $this->redis->hSet($uid, 'username', $info['username']);
            $this->redis->hSet($uid, 'status', $info['status']);
            $this->redis->hSet($uid, 'login_time', NOW_DATE);
            $this->redis->hSet($uid, 'ip', getIP());
            $this->redis->expire($uid, self::MAX_LOGIN_TIME); //设置过期时间
            return true;
        }
    }

    public function delLoginStatus($uid)
    {
        $redis = Redis::getInstance(App::getInstance()->env(self::REDIS_CONFIG));
        if ($this->getLoginStatus($uid)) {
            $redis->del($uid);
        }

        return true;
    }

    public function createSession($uid)
    {
        $session = Session::getInstance(App::getInstance()->env('session'));
        $session->set(self::SESSION_UID, $uid);
    }

    public function delSession()
    {
        $session = Session::getInstance(App::getInstance()->env('session'));
        $session->delete(self::SESSION_UID);
        $session->destroy();
    }
}