<?php

namespace app\features\Authentication;
use Morrow\Factory;
use Morrow\Debug;

class Delete_User_Button extends _Default {
	public function run($dom) {
		return '<a href="authentication/users/delete" class="button"><span class="fa fa-trash fa-fw"></span> Löschen</a>';
	}
}