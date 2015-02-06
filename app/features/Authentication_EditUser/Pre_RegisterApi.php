<?php

namespace app\features\Authentication_EditUser;
use Morrow\Factory;
use Morrow\Debug;

class Pre_RegisterApi {
	public function run($dom) {
		Factory::load('\app\features\Core\Api')->register('authentication/edit-user', [	
			'description'	=> 'Allows to edit a user.',
			'parameters'	=> [],
			'callback'		=> array('\\app\\features\\Authentication\\Api\\Edit_User', 'run'),
		]);
	}
}
