<?php

namespace app\features\Authentication\Api;
use Morrow\Factory;
use Morrow\Debug;

class Init extends _Default {
	public function run($dom) {
		Factory::load('\Api')->register('authentication/list-users', [	
			'description'	=> 'Lists all registered users.',
			'parameters'	=> [],
			'callback'		=> array('\\app\\features\\Authentication\\Api\\ListUsers', 'run'),
		]);

		return '';
	}
}