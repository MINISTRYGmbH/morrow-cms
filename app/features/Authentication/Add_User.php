<?php

namespace app\features\Authentication;
use Morrow\Factory;
use Morrow\Debug;

class Add_User extends _Default {
	public function run($dom) {
		$view = new \Morrow\Views\Serpent;

		// $api	= Factory::load('\Api');
		// $user	= $api->execute('authentication/add-user');
		// $view->setContent('user', $user);

		return $view;
	}
}