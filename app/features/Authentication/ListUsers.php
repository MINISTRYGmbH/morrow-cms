<?php

namespace app\features\Authentication;
use Morrow\Factory;
use Morrow\Debug;

class ListUsers extends _Default {
	public function run($dom) {
		$view	= new \Morrow\Views\Serpent;
		
		$api	= Factory::load('\Api');
		$users	= $api->execute('authentication/list-users');
		$view->setContent('users', $users);

		return $view;
	}
}