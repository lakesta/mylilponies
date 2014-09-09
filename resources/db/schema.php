<?php

$schema = new \Doctrine\DBAL\Schema\Schema();

/**
 * Ponies
 */

$ponies = $schema->createTable('ponies');

$ponies->addColumn('id', 'integer', array('unsigned' => true, 'unique' => true, 'autoincrement' => true));
$ponies->addColumn('name', 'string', array('length' => 32));
$ponies->addColumn('height', 'integer');
$ponies->addColumn('weight', 'integer');

$ponies->setPrimaryKey(array('id'));

/**
 * Furs
 */

$furs = $schema->createTable('furs');

$furs->addColumn('id', 'integer', array('unsigned' => true, 'unique' => true, 'autoincrement' => true));
$furs->addColumn('color', 'string', array('length' => 32));

$furs->setPrimaryKey(array('id'));

/**
 * Eyes
 */

$eyes = $schema->createTable('eyes');

$eyes->addColumn('id', 'integer', array('unsigned' => true, 'unique' => true, 'autoincrement' => true));
$eyes->addColumn('color', 'string', array('length' => 32));

$eyes->setPrimaryKey(array('id'));

/**
 * Pony Furs
 */

$pony_furs = $schema->createTable('pony_furs');

$pony_furs->addColumn("pony_id", "integer", array('unsigned' => true)); // FK to ponies
$pony_furs->addColumn("fur_id", "integer", array('unsigned' => true)); // FK to furs

$pony_furs->addForeignKeyConstraint($ponies, array("pony_id"), array("id"), array("onUpdate" => "CASCADE"));
$pony_furs->addForeignKeyConstraint($furs, array("fur_id"), array("id"), array("onUpdate" => "CASCADE"));


/**
 * Pony Eyes
 */

$pony_eyes = $schema->createTable('pony_eyes');

$pony_eyes->addColumn("pony_id", "integer", array('unsigned' => true)); // FK to ponies
$pony_eyes->addColumn("eye_id", "integer", array('unsigned' => true)); // FK to eyes

$pony_eyes->addForeignKeyConstraint($ponies, array("pony_id"), array("id"), array("onUpdate" => "CASCADE"));
$pony_eyes->addForeignKeyConstraint($eyes, array("eye_id"), array("id"), array("onUpdate" => "CASCADE"));


/**
 * Pony Friends
 */

$pony_friends = $schema->createTable('pony_friends');

$pony_friends->addColumn("pony_id", "integer", array('unsigned' => true)); // FK to ponies
$pony_friends->addColumn("friend_id", "integer", array('unsigned' => true)); // FK to ponies

$pony_friends->addForeignKeyConstraint($ponies, array("pony_id"), array("id"), array("onUpdate" => "CASCADE"));
$pony_friends->addForeignKeyConstraint($ponies, array("friend_id"), array("id"), array("onUpdate" => "CASCADE"));

return $schema;
