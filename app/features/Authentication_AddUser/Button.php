<?php

namespace app\features\Authentication_AddUser;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="authentication/users/add" class="button"><span class="fa fa-plus fa-fw"></span> Benutzer hinzufügen</a>';
	}
}