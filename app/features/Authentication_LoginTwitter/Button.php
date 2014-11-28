<?php

namespace app\features\Authentication_LoginTwitter;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="" class="button" style="background: #5ea9dd; color: #fff; border: 1px solid #5ea9dd;"><span class="fa fa-twitter fa-fw"></span>Twitter-Login</a>';
	}
}