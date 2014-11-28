<?php

namespace app\features\Authentication_ListUsers;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="authentication/users"><span class="fa fa-user fa-fw"></span> Benutzer</a>';
	}
}