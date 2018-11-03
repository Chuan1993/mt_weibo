<?php

return array(
    'success' => array(
        'code' => 100000,
        'msg'  => '操作成功'
    ),
    'failed' => array(
        'code' => 300000,
        'msg'  => '操作失败'
    ),
    'need_json_request' => array(
        'code' => 300001,
        'msg'  => '非法请求，仅支持json格式'
    ),
    'error_params' => array(
        'code' => 300002,
        'msg'  => '参数错误'
    ),
    'miss_cookie' => array(
        'code' => 300003,
        'msg'  => '缺失cookie'
    ),
    'no_user' => array(
        'code' => 300004,
        'msg'  => '不存在该用户'
    ),
    'miss_login' => array(
        'code' => 200000,
        'msg'  => '未登录'
    ),
    'duplicate_login' => array(
        'code' => 200001,
        'msg'  => '重复登录'
    ),
    'banned_account' => array(
        'code' => 200002,
        'msg'  => '账号已被封禁',
    ),
    'deleted_account' => array(
        'code' => 200003,
        'msg'  => '账号已被删除'
    ),
    'else_login' => array(
        'code' => 200002,
        'msg'  => '已在它处登录'
    ),
    'content_not_exist' => array(
        'code' => 200003,
        'msg' => '该动态不存在'
    ),
    'content_id_invalid' => array(
        'code' => 200004,
        'msg' => '输入的内容id有误'
    ),
    'comment_is_empty' => array(
        'code' => 200005,
        'msg' => '评论内容不能为空'
    ),
    'comment_commit_failed' => array(
        'code' => 200006,
        'msg' => '评论提交失败'
    ),
    'comment_id_is_empty' => array(
        'code' => 200007,
        'msg' => '缺少评论id'
    ),
    'comment_delete_failed' => array(
        'code' => 200008,
        'msg' => '评论删除失败'
    ),
    'content_id_is_empty' => array(
        'code' => 200009,
        'msg' => '动态id不能为空'
    ),
    'uid_invalid' => array(
        'code' => 200010,
        'msg' => '回复的用户id不合法'
    )
);