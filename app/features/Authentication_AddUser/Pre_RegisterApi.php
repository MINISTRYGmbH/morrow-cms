<?php

namespace app\features\Authentication_AddUser;
use Morrow\Factory;
use Morrow\Debug;

class Pre_RegisterApi {
	public function run($dom) {
		Factory::load('\Api')->register('authentication/add-user', [	
			'description'	=> 'Allows to add a user.',
			'parameters'	=> [],
			'callback'		=> array('\\app\\features\\Authentication_AddUser\\models\\Api', 'run'),
		]);
	}
}
