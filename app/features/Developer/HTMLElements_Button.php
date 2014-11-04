<?php

namespace app\features\Developer;
use Morrow\Factory;
use Morrow\Debug;

class HTMLElements_Button extends _Default {
	public function run($dom) {
		return '<a href="developer/html-elements" class="navi-item"><span class="fa fa-code fa-fw"></span> HTML-Elemente</a>';
	}
}