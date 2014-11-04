<?php

namespace app\features\Permissions;
use Morrow\Factory;
use Morrow\Debug;

class Headline extends _Default {
	public function run($dom) {
		return '<div class="navi-item navi-item-headline navi-item-small">Rechte</div>';
	}
}