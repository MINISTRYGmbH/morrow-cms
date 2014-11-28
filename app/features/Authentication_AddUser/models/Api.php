<?php

namespace app\features\Authentication_AddUser\models;
use Morrow\Factory;
use Morrow\Debug;

class Api extends _Default {
	public static function run() {
		$db = Factory::load('\MongoClient')->selectDB('cms');
		
		// $db->users->insert(array(
		// 	'firstname'		=> 'Christoph',
		// 	'lastname'		=> 'Erdmann',
		// 	'email'			=> 'christoph.erdmann@ministry.de',
		// 	'password'		=> 'test',
		// 	'created_at'	=> new \MongoDate(time()),
		// ));


		$data = $db->users->find();
		return iterator_to_array($data);
	}
}