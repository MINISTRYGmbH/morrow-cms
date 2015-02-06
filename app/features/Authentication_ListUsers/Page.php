<?php

namespace app\features\Authentication_ListUsers;
use Morrow\Factory;
use Morrow\Debug;

class Page {
	public function run($dom) {
		$view	= new \Morrow\Views\Serpent;

		$api	= Factory::load('\app\features\Core\Api');
		$users	= $api->execute('authentication/list-users');
		$view->setContent('users', $users);

		return $view;
	}
}
