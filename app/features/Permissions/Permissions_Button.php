<?php

namespace app\features\Permissions;
use Morrow\Factory;
use Morrow\Debug;

class Permissions_Button extends _Default {
	public function run($dom) {
		return '<a href="permissions/permissions" class="navi-item"><span class="fa fa-key fa-fw"></span> Rechte</a>';
	}
}