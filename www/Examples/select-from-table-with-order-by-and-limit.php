<?php
require 'connect.php';
require 'class-query.php';

header('Content-Type: text/plain');

// Get users from `user`
$q = new Query;
$q
    ->select(
        array(
            '`user`.`id`',
            '`user`.`name`',
            '`user`.`email`',
        )
    )
    ->from('`user`')
    ->order_by(
        array(
            '`user`.`email` ASC',
            '`user`.`name` ASC',
        )
    )
    ->limit(10)
    ->run();
    
$result = $q->run();
$count = $q->get_selected_count();

if (!($result && $count > 0)) {
    echo 'No users found.' . "\n";
}
else {
    while ($result && list($user['id'], $user['name'], $user['email']) = mysql_fetch_row($result)) {
        echo
            'Id: ' . $user['id'] . "\n" .
            'Name: ' . $user['name'] . "\n" .
            'Email: ' . $user['email'] . "\n" .
            "\n" .
            '';
    }
}

$q->show();

/*
SELECT
    `user`.`id`,
    `user`.`name`,
    `user`.`email`
FROM
    `user`
ORDER BY
    `user`.`email` ASC,
    `user`.`name` ASC
LIMIT
    10
*/