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
    ->group_by(
        array(
            '`name`',
            '`company`',
            '`email`'
        )
    )
    ->where_like(
        array(
            '`email`' =>'user@example.com'
        )
    )
    ->order_by(
        array(
            '`name` ASC',
            '`company` ASC'
        )
    );
    
$result = $q->run();
$count = $q->get_selected_count();

if (!($result && $count > 0)) {
    
}
else {
    while ($result && list() = mysql_fetch_row($result)) {
        
    }
}

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