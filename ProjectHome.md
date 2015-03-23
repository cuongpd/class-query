<h1>Class Query</h1>


<br />
# Examples #
## Select ##
### Select From Table ###
```
$q=new Query;
$q
	->select()
	->from('`user`')
	->run();
/* -> 
	SELECT
		*
	FROM
		`user`
*/
```
### Select With Criteria And Limit ###
```
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
/* -> 
	SELECT
		`user`.`user_id`,
		`user`.`name`,
		`user`.`email`
	FROM
		`user`
	WHERE
		`user_id`='123456' 
	LIMIT
		1
*/
if($q){
	$user=$q->get_selected();
	echo
		'Hello '.$user['name'].',<br />'.
		'Your email is currently set to '.$user['email'].' '.
		'and your user id is '.$user['user_id'].'.<br />'.
		'';
}
else{
	echo 'Sorry, user '.$user_id.' not found.';
}
```
### Select With Order By And Limit ###
```
// Find the user_id, name and email for all users from the `user` table
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
	->run();
/* -> 
	SELECT
		`user`.`user_id`,
		`user`.`name`,
		`user`.`email`
	FROM
		`user`
	ORDER BY
		`user`.`name` ASC
	LIMIT
		3
*/
if($q){
	$users=$q->get_selected();
	foreach($users as $user){
		echo
			'Name:'.$user['name'].'<br />'.
			'Email:'.$user['email'].'<br />'.
			'User Id:'.$user['user_id'].'.<br />'.
			'-----<br />'.
			'';
	}
}
else{
	echo 'Sorry, no users found.';
}
```
### Select With Page ###
```
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
/* -> 
	SELECT
		`user`.`user_id`,
		`user`.`name`,
		`user`.`email`
	FROM
		`user`
	ORDER BY
		`user`.`name` ASC
	LIMIT
		3,3
*/
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
```
## Insert ##
### Insert Into ###
```
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
/* -> 
	INSERT INTO `user`(
		`name`,
		`email`
	)
	VALUES(
		'user1402145267',
		'user1402145267@example.com'
	)
*/
```
### Insert Into, Select Inserted ###
```
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
```
## Update ##
### Update Table With Criteria And Limit ###
```
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
```
## Replace ##
```
// ...
```
## Delete ##
```
// ...
```
<br />
# Usage #
## Quick Install ##
  1. Download class-query from http://class-query.googlecode.com/svn/trunk/class-query.php
  1. include 'class-query.php';
  1. See [examples](http://code.google.com/p/class-query/source/browse/#svn/www/Examples) for usage.
## Example ##
  1. include 'class-query.php';
  1. Initialized the Query class and chain parameters.
  1. Call run(), show() or get() as the last chained function. That is, run the query, show/"echo" the query or return the query;
```
require 'class-query.php';
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
		'Your email is currently set to '.$user['email'].' '.
		'and your user id is '.$user['user_id'].'.<br />'.
		'';
}
else{
	echo 'Sorry, user '.$user_id.' not found.';
}
```
## See All Examples ##
[See all class-query examples.](http://code.google.com/p/class-query/source/browse/#svn/www/Examples)

<br />
## See Source ##
[See class-query source.](http://code.google.com/p/class-query/source/browse/trunk/class-query.php)

<br />
# Checkout #
```
svn checkout http://class-query.googlecode.com/svn/
```