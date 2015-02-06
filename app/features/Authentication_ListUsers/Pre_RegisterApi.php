<?php

namespace app\features\Authentication_ListUsers;
use Morrow\Factory;
use Morrow\Debug;

class Pre_RegisterApi {
	public function run($dom) {
		Factory::load('\app\features\Core\Api')->register('authentication/list-users', [	
			'description'	=> 'Lists all registered users.',
			'parameters'	=> [],
			'callback'		=> array('\\app\\features\\Authentication_ListUsers\\models\\Api', 'run'),
		]);
	}
}
