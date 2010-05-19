<?php
require 'class-query.php';

// Basic select
$q=new Query;
$q
    ->select()
    ->from('`user`')
    ->run();
    // ->show();
/* -> 
    SELECT
        *
    FROM
        `user`
*/