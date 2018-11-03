create table weibo_user00 (
uid int(11) primary key comment 'uid由Redis中的baseID生成，作为登录账号',
username varchar(30) not null default '',
password varchar(64) not null default '' comment '加密后生成固定64位',
sex tinyint(4) default 0 comment '0保密1男2女',
phone varchar(20) default '',
email varchar(30) default '',
status tinyint(4) not null default 1 comment '1正常2封禁3删除',
updated_at timestamp not null default '2018-08-31 00:00:00',
created_at timestamp not null default CURRENT_TIMESTAMP,
UNIQUE KEY unq_username (username) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微博用户表';