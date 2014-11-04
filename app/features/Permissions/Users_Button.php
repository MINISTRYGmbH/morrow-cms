<?php

namespace app\features\Permissions;
use Morrow\Factory;
use Morrow\Debug;

class Users_Button extends _Default {
	public function run($dom) {
		return '<a href="permissions/users" class="navi-item"><span class="fa fa-user fa-fw"></span> Benutzer</a>';
	}
}