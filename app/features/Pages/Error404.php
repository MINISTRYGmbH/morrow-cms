<?php

namespace app\features\Pages;
use Morrow\Factory;
use Morrow\Debug;

class Error404 extends _Default {
	public function run($dom) {
		$marker		= Factory::load('Config:feature')->get('if_does_not_exist');
		$is_content	= $dom->xpath->query($marker)->length;

		if ($is_content) return '';

		if (!$is_content && $this->Page->get('path.relative') !== '404') {
			$this->Url->redirect('404');
		}

		$this->Header->set('HTTP/1.0 404 Not Found');
		return $this->Views_Serpent;
	}
}