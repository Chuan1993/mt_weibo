create table weibo_comment00 (
comment_id int(11) unsigned AUTO_INCREMENT not null comment '评论id',
uid int(11) unsigned not null DEFAULT 0 comment '发表评论uid',
content_id int(11) not null DEFAULT 0 comment '评论文章',
to_uid int(11) not null DEFAULT 0 comment '被评论用户',
comment text NOT NULL DEFAULT ''  COMMENT '评论内容',
is_deleted tinyint(4) not null default 0 comment '是否删除状态，0正常1删除',
updated_at timestamp not null default '2018-08-31 00:00:00',
created_at timestamp not null default CURRENT_TIMESTAMP,
PRIMARY KEY (comment_id),
KEY key_content_id (content_id) USING BTREE
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='微博评论表';