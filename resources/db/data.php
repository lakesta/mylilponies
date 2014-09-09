<?php

$schema = $app['db']->getSchemaManager();
if ($schema->tablesExist('ponies')) {

	/* 
		PONIES 
	*/
	$app['db']->insert('ponies', array(
		'name' => 'Fabio',
		'height' => 36,
		'weight' => 450
	));

	$app['db']->insert('ponies', array(
		'name' => 'Calisto',
		'height' => 38,
		'weight' => 400
	));

	$app['db']->insert('ponies', array(
		'name' => 'Gux',
		'height' => 42,
		'weight' => 430
	));

	$app['db']->insert('ponies', array(
		'name' => 'Calippo',
		'height' => 34,
		'weight' => 370
	));

	$app['db']->insert('ponies', array(
		'name' => 'Guden',
		'height' => 45,
		'weight' => 410
	));


	/*
		FURS
	*/

	$app['db']->insert('furs', array(
		'color' => 'Black',
	));

	$app['db']->insert('furs', array(
		'color' => 'Brown',
	));

	$app['db']->insert('furs', array(
		'color' => 'White',
	));


	/*
		EYES
	*/

	$app['db']->insert('eyes', array(
		'color' => 'Black',
	));

	$app['db']->insert('eyes', array(
		'color' => 'Brown',
	));

	$app['db']->insert('eyes', array(
		'color' => 'Green',
	));


	/*
		PONY FURS
	*/

	$app['db']->insert('pony_furs', array(
		'pony_id' => 1,
		'fur_id' => 1
	));

	$app['db']->insert('pony_furs', array(
		'pony_id' => 2,
		'fur_id' => 1
	));

	$app['db']->insert('pony_furs', array(
		'pony_id' => 3,
		'fur_id' => 2
	));

	$app['db']->insert('pony_furs', array(
		'pony_id' => 4,
		'fur_id' => 2
	));

	$app['db']->insert('pony_furs', array(
		'pony_id' => 5,
		'fur_id' => 3
	));


	/*
		PONY EYES
	*/

	$app['db']->insert('pony_eyes', array(
		'pony_id' => 1,
		'eye_id' => 1
	));

	$app['db']->insert('pony_eyes', array(
		'pony_id' => 2,
		'eye_id' => 1
	));

	$app['db']->insert('pony_eyes', array(
		'pony_id' => 3,
		'eye_id' => 2
	));

	$app['db']->insert('pony_eyes', array(
		'pony_id' => 4,
		'eye_id' => 2
	));

	$app['db']->insert('pony_eyes', array(
		'pony_id' => 5,
		'eye_id' => 3
	));


	/*
		PONY FRIENDS
	*/

	// PONY ONE (2,3,4)
	$app['db']->insert('pony_friends', array(
		'pony_id' => 1,
		'friend_id' => 2
	));

	$app['db']->insert('pony_friends', array(
		'pony_id' => 1,
		'friend_id' => 3
	));

	$app['db']->insert('pony_friends', array(
		'pony_id' => 1,
		'friend_id' => 4
	));

	// PONY TWO (1,3,5)
	$app['db']->insert('pony_friends', array(
		'pony_id' => 2,
		'friend_id' => 1
	));

	$app['db']->insert('pony_friends', array(
		'pony_id' => 2,
		'friend_id' => 3
	));

	$app['db']->insert('pony_friends', array(
		'pony_id' => 2,
		'friend_id' => 5
	));


	// PONY THREE (1,4)
	$app['db']->insert('pony_friends', array(
		'pony_id' => 3,
		'friend_id' => 1
	));

	$app['db']->insert('pony_friends', array(
		'pony_id' => 3,
		'friend_id' => 4
	));

	// PONY FOUR (1,3)
	$app['db']->insert('pony_friends', array(
		'pony_id' => 4,
		'friend_id' => 1
	));

	$app['db']->insert('pony_friends', array(
		'pony_id' => 4,
		'friend_id' => 3
	));


	// PONY FIVE (2)
	$app['db']->insert('pony_friends', array(
		'pony_id' => 5,
		'friend_id' => 2
	));

}