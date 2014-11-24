<?php

namespace app\features\Authentication\Api;
use Morrow\Factory;
use Morrow\Debug;

class Edit_User_API extends _Default {
	public function run($dom) {
		Factory::load('\Api')->register('authentication/edit-user', [	
			'description'	=> 'Allows to edit a user.',
			'parameters'	=> [],
			'callback'		=> array('\\app\\features\\Authentication\\Api\\Edit_User', 'run'),
		]);
	}
}