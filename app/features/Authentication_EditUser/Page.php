<?php

namespace app\features\Authentication_EditUser;
use Morrow\Factory;
use Morrow\Debug;

class Page {
	public function run($dom) {
		$view = new \Morrow\Views\Serpent;

		// $api	= Factory::load('\Api');
		// $user	= $api->execute('authentication/add-user');
		// $view->setContent('user', $user);

		return $view;
	}
}