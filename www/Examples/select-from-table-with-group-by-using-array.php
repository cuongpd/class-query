<?php
    require 'class-query.php';

$q=new Query;
$result=$q
    ->select(
        array(
            '`name`',
            '`company`',
            '`email`'
        )
    )
    ->from('`invoice`')
    ->group_by(
        array(
            '`name`',
            '`company`',
            '`email`'
        )
    )
    ->where_like(
        array(
            '`email`'=>'user@example.com'
        )
    )
    ->order_by(
        array(
            '`name` ASC',
            '`company` ASC'
        )
    )
/*
    ->run();
*/
    ->show();
    exit;
/*
    SELECT
        `name`,
        `company`,
        `email`
    FROM
        `invoice`
    WHERE
        `email` LIKE '%user@example.com%' 
    GROUP BY
        `name`,
        `company`,
        `email`
    ORDER BY
        `name` ASC,
        `company` ASC
*/