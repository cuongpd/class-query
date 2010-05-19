<?php
    require 'class-query.php';

// Update row values in the `user` table
$q=new Query;
$q
    ->update('`user`')
    ->set(
        array(
            '`user`.`name`'=>'new_user_name',
            '`user`.`email`'=>'new_email@example.com'
        )
    )
    ->where_equal_to(
        array(
            '`user`.`user_id`'=>123456
        )
    )
    ->limit(1)
    ->run();
    // ->show();
/* -> 
    UPDATE
        `user`
    SET
        `user`.`name`='new_user_name', 
        `user`.`email`='new_email@example.com'
    WHERE
        `user`.`user_id`='123456' 
    LIMIT
        1
*/
if($q){
    echo 'User updated.';
}
else{
    echo 'Sorry, could not update user.';
}