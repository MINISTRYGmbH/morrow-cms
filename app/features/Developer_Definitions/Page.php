<?php

namespace app\features\Developer_Definitions;
use Morrow\Factory;
use Morrow\Debug;

class Page {
	public function run($dom) {
		$view = new \Morrow\Views\Serpent;

		$definitions = [
			'hidden' => [
				'validator' => [],
				'field' => ['hidden', 'dummy'],
			],
			'input' => [
				'validator' => ['required', 'email'],
				'label' => ['input', 'switched to an email type field'],
				'field' => ['input', ['type' => 'email'], 'prefix', 'suffix'],
			],
			'text' => [
				'validator' => [],
				'label' => ['text'],
				'field' => ['text'],
			],
			'password' => [
				'validator' => [],
				'label' => ['password'],
				'field' => ['password'],
			],
			'file' => [
				'validator' => [],
				'label' => ['file'],
				'field' => ['file'],
			],

			'<h3>Readonly fields</h3>',

			'textarea' => [
				'validator' => [],
				'label' => ['textarea'],
				'field' => ['textarea'],
			],
			'radiogroup' => [
				'validator' => [],
				'label' => ['radio'],
				'field' => ['radio', ['mr' => 'Herr', 'mrs' => 'Frau'], [], true],
				'default' => 'mrs',
			],
			'checkboxgroup' => [
				'validator' => ['required'],
				'label' => ['checkbox'],
				'field' => ['checkbox', ['key1' => 'Option 1', 'key2' => 'Option 2', 'key3' => 'Option 3'], [], true],
				'default' => ['key1', 'key3'],
			],
			'select' => [
				'validator' => ['required'],
				'label' => ['select'],
				'field' => ['select', ['' => 'Bitte wählen', 'yes' => ['Ja', 'Si'], 'no' => 'Nein']],
			],
			'list' => [
				'validator' => ['required'],
				'label' => ['select_list'],
				'field' => ['select_list', ['' => 'Bitte wählen', 'yes' => ['Ja', 'Si'], 'no' => 'Nein'], ['multiple' => 'multiple', 'size' => '10']],
			],
		];

		// generate html
		$form_html = Factory::load('Event')->trigger('form.handle', array(
			$definitions,
			Factory::load('Language')->_('Save'),
			'authentication/add-user',
			'Definitions saved.'
		));
		$view->setContent('form_html', $form_html);

		return $view;
	}
}
