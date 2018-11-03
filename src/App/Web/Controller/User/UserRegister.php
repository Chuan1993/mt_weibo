<?php
/**
 * Message:
 * User: jzc
 * Date: 2018/9/7
 * Time: 上午10:08
 * Return:
 */

namespace Mt\App\Web\Controller\User;

use Mt\App\Web\Controller\Controller;

class UserRegister extends Controller
{
    public function main()
    {
        $params = [
            'username' => 'test',
            'password' => '123456',
            'client_id' => CLIENT_WEB_ID
        ];
        echo setParams($params);

    }
}