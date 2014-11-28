<?php

namespace app\features\Authentication_LoginFacebook;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="" class="button" style="background: #3b5998; color: #fff; border: 1px solid #3b5998;"><span class="fa fa-facebook fa-fw"></span>Facebook-Login</a>';
	}
}