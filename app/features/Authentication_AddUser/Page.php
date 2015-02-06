<?php

namespace app\features\Authentication_AddUser;
use Morrow\Factory;
use Morrow\Debug;

class Page extends Factory {
	public function run() {
		$view = new \Morrow\Views\Serpent;

		$definitions = [
			'email' => [
				'validator' => ['required', /*'email'*/],
				'label' => ['E-Mail-Adresse'],
				'field' => ['input', ['type' => 'email']],
			],
		];

		// generate html
		$form_html = Factory::load('Event')->trigger('form.handle', array(
			$definitions,
			Factory::load('Language')->_('Invite'),
			'authentication/add-user',
			'The user was successfully invited.'
		));
		$view->setContent('form_html', $form_html);

		return $view;
	}
}
