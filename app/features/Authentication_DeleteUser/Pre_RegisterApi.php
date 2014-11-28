<?php

namespace app\features\Authentication_DeleteUser;
use Morrow\Factory;
use Morrow\Debug;

class Pre_RegisterApi {
	public function run($dom) {
		Factory::load('\Api')->register('authentication/delete-user', [	
			'description'	=> 'Allows to delete a user.',
			'parameters'	=> [],
			'callback'		=> array('\\app\\features\\Authentication\\Api\\Delete_User', 'run'),
		]);
	}
}
