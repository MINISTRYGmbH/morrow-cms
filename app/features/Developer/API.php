<?php

namespace app\features\Developer;
use Morrow\Factory;
use Morrow\Debug;

class API extends _Default {
	public function run($dom) {
		$view = new \Morrow\Views\Serpent;

		$api = Factory::load('\Api');
		$toc = $api->toc();
		$view->setContent('toc', $toc);

		return $view;
	}
}