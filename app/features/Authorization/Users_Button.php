<?php

namespace app\features\Authorization;
use Morrow\Factory;
use Morrow\Debug;

class Users_Button extends _Default {
	public function run($dom) {
		return '<a href="authorization/users"><span class="fa fa-user fa-fw"></span> Benutzer</a>';
	}
}