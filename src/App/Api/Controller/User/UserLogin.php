<?php

/**
 * Message: 登录校验
 * User: jzc<jzc1@meitu.com>
 * Date: 2018/9/4
 * Time: 下午1:30
 * Return:
 */
namespace Mt\App\Api\Controller\User;

use Mt\App\Api\Controller\Controller;
use Mt\Model\UserModel;

class UserLogin extends Controller
{
    protected $requireLogin = false;
    public function main()
    {
        $needKeys = ['uid', 'password', 'client_id'];
        $params = json_decode(base64_decode($this->request->input('params')), true);

        foreach ($params as $k => $v) {
            if (!in_array($k, $needKeys)) {
                unset($params[$k]);
            }

            if (!$v) {
                unset($params[$k]);
            }

            if ($k == 'client_id') {
                if ($v != CLIENT_WEB_ID) {
                    unset($params[$k]);
                }
            }
        }

        if (array_keys($params) != $needKeys) {
            $this->outputJson('error_params');
        }

        $uid = $option['uid'] = $params['uid'];
        $option['password'] = $params['password'];

        $user = UserModel::getInstance();
        $status = $user->getLoginStatus($uid);

        //已登录状态
        if (!empty($status)) {
            //如果登录IP和已存储IP相同
            if ($status['ip'] == getIP()) {
                $this->outputJson('duplicate_login');
            } else {
                $this->outputJson('else_login');
            }
        }

        //验证账号密码并获取信息
        $userInfo = $user->getOneByOption($option, $uid);

        if (empty($userInfo)) {
            $this->outputJson('failed');
        }

        if ($userInfo['status'] == UserModel::STATUS_BANNED) {
            $this->outputJson('banned_account');
        }

        if ($userInfo['status'] == UserModel::STATUS_DELETED) {
            $this->outputJson('deleted_account');
        }

        //设置登录状态
        if ($user->setLoginStatus($uid, $userInfo)) {
            $this->outputJson('success', $user->getLoginStatus($uid));
        } else {
            $this->outputJson('failed');
        }
    }
}