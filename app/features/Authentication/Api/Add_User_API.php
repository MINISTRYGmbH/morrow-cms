<?php

namespace app\features\Authentication\Api;
use Morrow\Factory;
use Morrow\Debug;

class Add_User_API extends _Default {
	public function run($dom) {
		Factory::load('\Api')->register('authentication/add-user', [	
			'description'	=> 'Allows to add a user.',
			'parameters'	=> [],
			'callback'		=> array('\\app\\features\\Authentication\\Api\\Add_User', 'run'),
		]);
	}
}