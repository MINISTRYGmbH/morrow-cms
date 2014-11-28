<?php

namespace app\features\Authentication_DeleteUser;
use Morrow\Factory;
use Morrow\Debug;

class Page extends _Default {
	public function run($dom) {
		$view = new \Morrow\Views\Serpent;

		// $api	= Factory::load('\Api');
		// $user	= $api->execute('authentication/add-user');
		// $view->setContent('user', $user);

		return $view;
	}
}