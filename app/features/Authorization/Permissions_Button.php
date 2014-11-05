<?php

namespace app\features\Authorization;
use Morrow\Factory;
use Morrow\Debug;

class Permissions_Button extends _Default {
	public function run($dom) {
		return '<a href="authorization/permissions"><span class="fa fa-key fa-fw"></span> Rechte</a>';
	}
}