<?php

require 'lib.php'; // functions for test

Sdb::setConfig($config['db']);

// clear side effects for all

// unset all session
foreach ($_SESSION as $key => $value) {
    unset($_SESSION[$key]);
}

if (isset($_GET['u'])) {
    redirect();
}

require_once CORE_ROOT . 'BasicModel.php';

// clear db entries that was insert by test
include 'clear_db.php';

$all_pass = true;

begin_test();
test(1, 1, 'test for 1 === 1');

begin_test();
$username = 'test_user';
$password = 'password';
$realname = '小池';
$phone = '13711231212';
$email = 'cumt.xiaochi@gmail.com';
$info = compact(
    'username',
    'password',
    'realname',
    'phone',
    'email');
$customer = Customer::create($info);
test(1, 1, array('name' => 'register Customer, db'));

begin_test();
test(
    User::check($username, $password),
    true,
    array('name' => 'User::check($username, $password)'));

begin_test();
$username = 'test_admin';
$password = 'password';
$user = User::getByName('root');
$superadmin = $user->instance();
$admin = $superadmin->createAdmin(compact('username', 'password'));
$ideal_arr = array(
    'name' => $username,
    'password' => md5($password),
    'type' => 'Admin');
$id = Pdb::lastInsertId();
$real_arr = Pdb::fetchRow(
    'name, password, type', 
    User::$table, 
    array('id=?' => $id));
test($real_arr, $ideal_arr, array('name' => 'Super Admin create Admin, db'));

begin_test();
$prd_types = Product::types();
$info = array(
    'name' => '唯爱心形群镶女戒_test',
    'type' => reset(array_keys($prd_types)),
    'material' => json_encode(array(
        'PT950', 
        '白18K金',
        '黄18K金',
        '红18K金')),
    'rabbet_start' => '0.30',
    'rabbet_end' => '0.60',
    'weight' => 9,
    'small_stone' => 3,
    'st_weight' => 2.1,
    'images' => array(
        '400' => array(
            '/test/static/img/i400-1.jpg',
            '/test/static/img/i400-2.jpg',
            '/test/static/img/i400-3.jpg',),
        'thumb' => array(
            '/test/static/img/i80-1.jpg',
            '/test/static/img/i80-2.jpg',
            '/test/static/img/i80-3.jpg')));
$product = Product::create($info);
test(1, 1, array('name' => 'Admin post Product, db'));

begin_test();
$address = $customer->defaultAddress();
$address->edit(array(
    'name' => '小池',
    'phone' => '14722320989',
    'detail' => '深圳罗湖区田贝'));
test(1, 1, array('name' => 'edit Address'));


begin_test();
$cart = $customer->cart();
test(+$cart->count(), 2, array('name' => 'Cart count()'));

begin_test();
$cart->submit();
test(1, 1, array('name' => 'Customer submit a Cart'));

