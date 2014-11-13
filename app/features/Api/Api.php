<?php

namespace app\features\Api;
use Morrow\Factory;
use Morrow\Debug;

class Api extends _Default {
	public function run($dom) {
		$api = Factory::load('\Api');
		
		header('Content-Type: application/json');
		echo json_encode($api);
		die();
	}
}