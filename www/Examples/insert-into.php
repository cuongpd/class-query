<?php
	require 'class-query.php';
	// Insert a new user into the `user` table
	$name='user'.rand();
	$email=$name.'@example.com';
	$q=new Query;
	$q
		->insert_into(
			'`user`',
			array(
				'`name`'=>$name,
				'`email`'=>$email
			)
		)
		->run();
	if($q){
		echo 'User added.';
	}
	else{
		echo 'Sorry, could not add user.';
	}
?>