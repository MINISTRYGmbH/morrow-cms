<?php

namespace app\features\Authentication_AddUser\models;
use Morrow\Factory;
use Morrow\Debug;

class Api {
	public static function run($data) {
		$doc = Factory::load('Event')->trigger('data.xml.get');
		Debug::dump($data);

		// get or create users root node
		$users = $doc->find('./users');
		if ($users === null) {
			$doc->append('users', []);
			$users = $doc->find('./users');
		}

		// normalise email address
		$data['email'] = preg_replace_callback('|(.+)@([^@]+)|', function($data){
			return $data[1] . '@' . strtolower($data[2]);
		}, $data['email']);
		
		// search for user with the same email address
		// ...
		
		
		$users->append('user', $data);
		return $data['email'];
	}
}

