<?php

namespace app\features\Developer_HTMLElements;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="developer/html-elements"><span class="fa fa-code fa-fw"></span> HTML-Elemente</a>';
	}
}