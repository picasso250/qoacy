<?php

$tables_to_clear = array(
    User::table(),
    Customer::table(),
    Product::table(),
    Cart::table(),
    Address::table(),
    UserLog::table(),
    Account::table(),
    AccountHistory::table());

$db = Sdb::getDb();
foreach ($tables_to_clear as $table) {
    $db->exec("TRUNCATE TABLE $table");
}

if (_get('exit')) {
    echo '<script src="static/hide.js"></script>';
    echo '<div class="conclusion pass">All Clear!</div>';
    exit;
}
