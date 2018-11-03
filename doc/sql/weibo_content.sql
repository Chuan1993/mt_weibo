create table weibo_content00 (
content_id int(11) unsigned not null comment '动态id,主键',
uid int(11) unsigned not null DEFAULT 0 comment '发表用户id',
content text NOT NULL  COMMENT '发表内容',
is_trans tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否转发，1:是; 2:否',
trans_id int(11) unsigned not null DEFAULT 0 comment '转发动态id',
updated_at timestamp not null default '2018-08-31 00:00:00',
created_at timestamp not null default CURRENT_TIMESTAMP,
PRIMARY KEY (content_id),
KEY key_uid (uid) USING BTREE
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COMMENT='微博动态表';
