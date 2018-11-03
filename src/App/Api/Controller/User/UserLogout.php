<?php
/**
 * Message:
 * User: jzc<jzc1@meitu.com>
 * Date: 2018/9/5
 * Time: 下午1:36
 * Return:
 */

namespace Mt\App\Api\Controller\User;

use Mt\App\Api\Controller\Controller;
use Mt\Model\UserModel;

class UserLogout extends Controller
{
    public function main()
    {
        $uid = $this->request->input('uid');

        $user = UserModel::getInstance();

        if ($user->delLoginStatus($uid)) {
            $this->outputJson('success');
        }

        $this->outputJson('failed');
    }
}