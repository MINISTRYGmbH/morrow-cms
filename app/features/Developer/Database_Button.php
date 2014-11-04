<?php

namespace app\features\Developer;
use Morrow\Factory;
use Morrow\Debug;

class Database_Button extends _Default {
	public function run($dom) {
		return '<a href="developer/database" class="navi-item"><span class="fa fa-database fa-fw"></span> Datenbank</a>';
	}
}