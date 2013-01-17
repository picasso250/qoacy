<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION'); // in fact, even if this is exucted by user, would it show anything?
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

$config['site']['name'] = 'qoacy';

// error info
$config['error']['info'] = array(
    'PASSWORD_EMPTY' => 'plz enter password',
    'REPASSWORD_EMPTY' => '请重新输入密码以确认',
    'NEW_PASSWORD_EMPTY' => '请输入新密码',
    'PASSWORD_NOT_SAME' => '两次输入的密码不一致，请重新输入',
    'USERNAME_EMPTY' => 'username empty',
    'USERNAME_OR_PASSWORD_INCORRECT' => '用户名或者密码不正确',
    'PASSWORD_INCORRECT' => '密码不正确',
    'USER_ALREADY_EXISTS' => '这个用户名已经被使用，请重新选择用户名',
    'REALNAME_EMPTY' => '请填写真实姓名',
    'PHONE_EMPTY' => '请填写手机号码',
    'EMAIL_EMPTY' => '请填写您的电子邮箱', );


$config['gender'] = array(
    'male' => '男',
    'female' => '女');

// 普通用户的导航
$config['navs']['user'] = '
选购货品 index
 + 选购货品
我的订单 order
 - 待确认 submit
 - 已交工厂 infactory
 - 工厂完工 finish
 + 全部订单 all
我的资料 my 
 + 个人资料 info
 - 修改密码 password
';

// 管理员的导航
$config['navs']['admin'] = '
订单管理 order
 - 待确认 submit
 - 已交工厂 infactory
 - 工厂完工 finish
 - 已取消 cancel
 + 全部订单 all
 - 工厂未结清 tobepaid.factory
 - 用户未结清 tobepaid.customer
货品管理 product
 + 货品列表 
 - 发布货品 post
用户管理 user
 + 用户列表 
 - 新增用户 add
工厂管理 factory
 + 工厂列表
 - 新增工厂 add
数据统计 statistics
 - 历史金价 gold_price
 + 销量统计 sale
系统设置 setting
 + 全局设置
 - 修改密码 password
';

$config['navs']['superadmin'] = '
管理员 admin
 + 管理员列表 
 - 新增管理员 add
系统设置 setting
 + 修改密码 password
';

$config['description'] = '电商';
$config['keywords'] = array('电商');
