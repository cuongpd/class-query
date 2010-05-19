<?php
require 'connect.php';
require 'class-query.php';

header('Content-Type: text/plain');

// Basic select
$q = new Query;
$q
    ->select()
    ->from('`user`')
    ->run();
    
$q->show();

/*
SELECT
    *
FROM
    `user`
*/