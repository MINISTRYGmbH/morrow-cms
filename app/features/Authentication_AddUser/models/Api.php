<?php

namespace app\features\Authentication_AddUser\models;
use Morrow\Factory;
use Morrow\Debug;

class Api {
	public static function run($user) {
		$doc = Factory::load('Event')->trigger('data.xml.get');

		// get or create users root node
		$users = $doc->find('./users');
		if ($users === null) {
			$doc->append('users', []);
			$users = $doc->find('./users');
		}

		// normalise email address
		$user['email'] = preg_replace_callback('|(.+)@([^@]+)|', function($user){
			return $user[1] . '@' . strtolower($user[2]);
		}, $user['email']);

		// search for user with the same email address
		if ($doc->find('./users/user/email[text()="'.$user['email'].'"]')) {
			throw new \Exception('User with this email address already exists.');
		}

		// send mail
		$body = '
			Hello,

			you were invited to become a CMS user at
			[URL]
		';

		Factory::load('Event')->trigger('mail.send', [
			$user['email'],
			'You were invited to become a CMS user',
			'
			Hello,

			you were invited to become a CMS user at
			[URL]
			',
		]);

		//$users->append('user', $user);
		return $user['email'];
	}
}

