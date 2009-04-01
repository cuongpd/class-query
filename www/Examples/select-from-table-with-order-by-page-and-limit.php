<?php
	require 'class-query.php';
	// Page 2 of the user_id, name and email for all users from the `user` table
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
		->order_by('`user`.`name` ASC')
		->limit(3)
		->page(2)
		->run();
	if($q){
		$users=$q->get_selected();
		foreach($users as $user){
			echo
				'Name:'.$user['name'].'<br />'.
				'Email:'.$user['email'].'<br />'.
				'User Id:'.$user['user_id'].'<br />'.
				'-----<br />'.
				'';
		}
	}
	else{
		echo 'Sorry, no users found.';
	}
?>