<?php

namespace app\features\Authentication;
use Morrow\Factory;
use Morrow\Debug;

class Add_User_Button extends _Default {
	public function run($dom) {
		return '<a href="authentication/users/add" class="button"><span class="fa fa-plus fa-fw"></span> Benutzer hinzufügen</a>';
	}
}