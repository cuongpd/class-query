<?php
require 'connect.php';
require 'class-query.php';

header('Content-Type: text/plain');

$q = new Query;
$q
    ->select(
        array(
            '`name`',
            '`company`',
            '`email`',
        )
    )
    ->from('`invoice`')
    ->where_equal_to(
        array(
            '`email`' => 'user@example.com',
        )
    )
    ->group_by(
        array(
            '`name`',
            '`company`',
            '`email`',
        )
    )
    ->order_by(
        array(
            '`name` ASC',
            '`company` ASC',
        )
    );
    
$q->show();

/*
SELECT
    `name`,
    `company`,
    `email`
FROM
    `invoice`
WHERE
    `email` = "user@example.com" 
GROUP BY
    `name`,
    `company`,
    `email`
ORDER BY
    `name` ASC,
    `company` ASC
*/