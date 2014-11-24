<?php

namespace app\features\Authentication\Api;
use Morrow\Factory;
use Morrow\Debug;

class List_Users extends _Default {
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