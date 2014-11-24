<?php

namespace app\features\Authentication\Api;
use Morrow\Factory;
use Morrow\Debug;

class Delete_User_API extends _Default {
	public function run($dom) {
		Factory::load('\Api')->register('authentication/delete-user', [	
			'description'	=> 'Allows to delete a user.',
			'parameters'	=> [],
			'callback'		=> array('\\app\\features\\Authentication\\Api\\Delete_User', 'run'),
		]);
	}
}