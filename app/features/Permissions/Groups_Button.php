<?php

namespace app\features\Permissions;
use Morrow\Factory;
use Morrow\Debug;

class Groups_Button extends _Default {
	public function run($dom) {
		return '<a href="permissions/groups" class="navi-item"><span class="fa fa-users fa-fw"></span> Gruppen</a>';
	}
}