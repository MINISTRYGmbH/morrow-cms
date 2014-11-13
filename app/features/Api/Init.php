<?php

namespace app\features\Api;
use Morrow\Factory;
use Morrow\Debug;

class Init extends _Default {
	public function run($dom) {
		$api = Factory::load('\Api');

		$api->register('authentication/add-user',
			array('\\app\\features\\Authentication\\Api', 'addUser'),
			array(
				'$firstname'	=> 'The first name of the user',
				'$lastname'		=> 'The last name of the user',
				'$email'		=> 'The email address of the user used for authentication',
				'$password'		=> 'The password of the user used for authentication',
			)
		);

		$api->register('authentication/delete-user',
			array('\\app\\features\\Authentication\\Api', 'deleteUser'),
			array(
				'$email' => 'The email address of the user',
			)
		);

		$api->register('authentication/authenticate-user',
			array('\\app\\features\\Authentication\\Api', 'authenticateUser'),
			array(
				'$email'	=> 'The email address of the user',
				'$password'	=> 'The password of the user (not required, omit if you use an authentication method that uses a confirmed email address like OpenID Connect etc.)',
			)
		);

		return '';
	}
}