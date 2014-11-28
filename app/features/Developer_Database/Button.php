<?php

namespace app\features\Developer_Database;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="developer/database"><span class="fa fa-database fa-fw"></span> Datenbank</a>';
	}
}