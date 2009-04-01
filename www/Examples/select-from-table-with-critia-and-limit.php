<?php
	require 'class-query.php';
	// Find the user_id, name and email for the specified user from the `user` table
	$user_id=123456;
	$q=new Query;
	$q
		->select(
			array(
				'`user`.`user_id`',
				'`user`.`name`',
				'`user`.`email`'
			)
		)
		->from('`user`')
		->where_equal_to(
			array(
				'`user_id`'=>$user_id
			)
		)
		->limit(1)
		->run();
	if($q){
		$user=$q->get_selected();
		echo
			'Hello '.$user['name'].',<br />'.
			'Your email is currently set to '.$user['name'].' '.
			'and your user id is '.$user['user_id'].'.<br />'.
			'';
	}
	else{
		echo 'Sorry, user '.$user_id.' not found.';
	}
?>