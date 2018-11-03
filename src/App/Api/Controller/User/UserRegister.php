<?php
/**
 * Message:
 * User: jzc<jzc1@meitu.com>
 * Date: 2018/9/4
 * Time: 下午8:21
 * Return:
 */

namespace Mt\App\Api\Controller\User;

use Mt\App\Api\Controller\Controller;
use Mt\Model\UserModel;

class UserRegister extends Controller
{
    protected $requireLogin = false;
    public function main()
    {
        $needKeys = ['username', 'password', 'client_id'];
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

        $data = [
            'username' => $params['username'],
            'password' => setPassword($params['password']),
        ];

        $user = UserModel::getInstance();
        if ($uid = $user->insert($data)) {
            $this->outputJson('success', ['uid' => $uid]);
        }

        $this->outputJson('failed');
    }
}