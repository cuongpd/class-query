<?php
require 'connect.php';
require 'class-query.php';

header('Content-Type: text/plain');

// Select the specified user from `user`

$id = 1;
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
    ->where_equal_to(
        array(
            '`user`.`id`' => $id,
        )
    )
    ->limit(1);
    
$result = $q->run();
$count = $q->get_selected_count();

if (!($result && $count > 0)) {
    echo 'User ' . $id . ' not found.' . "\n";
}
else {
    list($user['id'], $user['name'], $user['email']) = mysql_fetch_row($result);
    echo
        'Hello ' . $user['name'] . ', ' .
        'Your email is currently set to ' . $user['email'] . ' ' .
        'and your user id is ' . $user['id'] . '.' . "\n" .
        '';
    
}

$q->show();

/*
Hello user1039877430, Your email is currently set to user1039877430@example.com and your user id is 1.

SELECT
    `user`.`id`,
    `user`.`name`,
    `user`.`email`
FROM
    `user`
WHERE
    `user`.`id` = 1 
LIMIT
    1
*/