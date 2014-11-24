<?php

namespace app\features\Authentication;
use Morrow\Factory;
use Morrow\Debug;
use Morrow\API;

class Init extends _Default {
	public function run($dom) {
		if ($this->Page->get('path.relative') === '') {
			$this->Url->redirect('login');
		}
	}
}