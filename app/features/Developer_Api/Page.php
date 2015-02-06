<?php

namespace app\features\Developer_Api;
use Morrow\Factory;
use Morrow\Debug;

class Page {
	public function run($dom) {
		$view = new \Morrow\Views\Serpent;

		$api = Factory::load('\app\features\Core\Api');
		$toc = $api->toc();
		$view->setContent('toc', $toc);

		return $view;
	}
}
