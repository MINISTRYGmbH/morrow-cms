<?php

namespace app\features\Authentication_AddUser;
use Morrow\Factory;
use Morrow\Debug;

class Page extends Factory {
	public function run($dom) {
		$view = new \Morrow\Views\Serpent;

		$rules =  [
			'email'    => ['required', 'email'],
		];

		$input  = $this->Input->get();
		$errors = [];

		if (isset($input['sent'])) {
			if ($data = $this->Validator->filter($input, $rules, $errors, true)) {
				Debug::dump($data);
			} else {
				
			}
		}
		
		$form = Factory::load('\Form', $input, $errors);
		$view->setContent('form', $form);
		
		
		// $api	= Factory::load('\Api');
		// $user	= $api->execute('authentication/add-user');
		// $view->setContent('user', $user);

		return $view;
	}
}