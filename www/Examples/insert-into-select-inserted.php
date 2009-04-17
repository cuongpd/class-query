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
		// ->show();
	/* -> 
		INSERT INTO `user`(
			`name`,
			`email`
		)
		VALUES(
			'user1151175574',
			'user1151175574@example.com'
		)
	*/
	if($q){
		$user_id=$q->get_inserted();
		$q=new Query;
		$q
			->select_from(
				'`user`',
				array(
					'`user`.`user_id`',
					'`user`.`name`',
					'`user`.`email`'
				)
			)
			->where_equal_to(
				array(
					'`user`.`user_id`'=>$user_id
				)
			)
			->limit(1)
			->run();
			// ->show();
		/* -> 
			SELECT
				`user`.`user_id`,
				`user`.`name`,
				`user`.`email`
			FROM
				`user`
			WHERE
				`user`.`user_id`='1151175574'
			LIMIT
				1
		*/
		if($q){
			$user=$q->get_selected();
			echo
				'Name:'.$user['name'].'<br />'.
				'Email:'.$user['email'].'<br />'.
				'User Id:'.$user['user_id'].'<br />'.
				'-----<br />'.
				'';
		}
		else{
			echo 'Sorry, user not found.';
		}
	}
	else{
		echo 'Sorry, could not add user.';
	}
?>