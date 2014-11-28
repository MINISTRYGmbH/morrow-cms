<?php

namespace app\features\Authentication_LoginRedirect;
use Morrow\Factory;
use Morrow\Debug;
use Morrow\API;

class Pre_Redirect extends Factory {
	public function run($dom) {
		if ($this->Page->get('path.relative') === '') {
			$this->Url->redirect('login');
		}
	}
}