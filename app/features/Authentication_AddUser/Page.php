<?php

namespace app\features\Authentication_AddUser;
use Morrow\Factory;
use Morrow\Debug;

class Page extends Factory {
	public function run() {
		$view = new \Morrow\Views\Serpent;

		$definitions = [
			'email' => [
				'validator' => ['required', 'email'],
				'label' => ['E-Mail-Adresse'],
				'field' => ['input', ['type' => 'email']],
			],
			'dummy2' => [
				'validator' => ['required'],
				'label' => ['Select'],
				'field' => ['select', ['' => 'Bitte wählen', 'yes' => 'Ja', 'no' => 'Nein'], ['a' => 'b']],
			],
			'checkbox' => [
				'validator' => ['required'],
				'label' => ['Checkbox'],
				'field' => ['checkbox', 'tnb'],
			],
			'checkbox2' => [
				'validator' => [],
				'label' => ['Was soll das bringen?', 'frage ich dich'],
				'field' => ['input', ['type' => 'email']],
			],
		];
		
		// How to add new field definitions
		//\Morrow\Form::register('email', function($name){
		//	return \Morrow\Form::_getDefaultInputHtml('email', $name, $attributes);
		//});
		
		// "radiogroup" und "checkboxgroup" erstellen
		
		$form_html = Factory::load('Event')->trigger('form.handle', array(
			'authentication/add-user',
			$definitions
		));
		$view->setContent('form_html', $form_html);
		
		return $view;
	}
}