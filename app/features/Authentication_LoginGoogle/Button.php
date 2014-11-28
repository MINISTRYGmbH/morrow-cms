<?php

namespace app\features\Authentication_LoginGoogle;
use Morrow\Factory;
use Morrow\Debug;

class Button {
	public function run($dom) {
		return '<a href="" class="button" style="background: #df4a32; color: #fff; border: 1px solid #df4a32;"><span class="fa fa-google fa-fw"></span>Google-Login</a>';
	}
}