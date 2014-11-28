<?php

namespace app\features\Authentication_DeleteUser;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="authentication/users/delete" class="button"><span class="fa fa-trash fa-fw"></span> Löschen</a>';
	}
}