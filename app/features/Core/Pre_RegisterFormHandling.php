<?php

namespace app\features\Core;
use Morrow\Factory;
use Morrow\Debug;

class Pre_RegisterFormHandling {
	public static $user_fieldnames;

	public static function addElement($fieldname, $namespace) {
		self::$user_fieldnames[$fieldname] = $namespace;
	}

	public function run($dom) {
		// init the validator for the csrf token
		Factory::load('Validator')->add('csrf_token', function(){
			return Factory::load('Security')->checkCSRFToken();
		}, 'CSRF token is not valid');

		// functionality to define form fields which are not defined in the \Morrow\Form class
		Factory::load('Event')->on('form.register_field', function($event, $data) {
			list($fieldname, $namespace) = $data;
			self::$user_fieldnames[$fieldname] = $namespace;
		});

		// functionality to validate and render a complete form
		Factory::load('Event')->on('form.handle', function($event, $data) {
			list($definitions, $save_button, $api_url, $success) = $data;

			// add CSRF protection
			$token = Factory::load('Security')->getCSRFToken();
			$definitions['csrf_token'] = [
				'validator' => ['required', 'csrf_token'],
				'field' => ['hidden', $token],
			];

			// create validator rules and default values
			foreach ($definitions as $fieldname => $definition) {
				if (isset($definition['validator'])) {
					$rules[$fieldname] = $definition['validator'];
				}
			}

			// validate
			$input = Factory::load('Input')->get();
			$errors = [];

			if (isset($input['sent'])) {
				if ($data = Factory::load('Validator')->filter($input, $rules, $errors, true)) {
					// possibility for a user hook
					$data = Factory::load('Event')->trigger('form.data.before_save.modify', $data);

					// remove csrf token before we pass it to the api
					unset($data['csrf_token']);

					try {
						$api = Factory::load('\app\features\Core\Api')->execute($api_url, $data);
						$success_message = $success();
					} catch (\Exception $e) {
						$error_message = '<small>' . $e->getFile() . ' ('.$e->getLine().')</small><br />' . $e->getMessage();
					}

				} else {
					$error_message = 'Please correct the marked fields.';
					// trigger form failure event
				}
			} else {
				// create validator rules and default values
				foreach ($definitions as $fieldname => $definition) {
					if (isset($definition['default'])) {
						$input[$fieldname] = $definition['default'];
					}
				}
			}

			// generate form instance
			$form = Factory::load('\app\features\Core\Form', $input, $errors, $definitions);

			$html = '<form method="post">';
			$html .= $form->hidden('sent', 'true');

			// show global error notice
			if (isset($error_message)) {
				$html .= '<div class="message message-error message-form"><span class="fa fa-exclamation-circle"></span> '.$error_message.'</div>';
			}

			if (isset($success_message)) {
				$html .= '<div class="message message-form"><span class="fa fa-exclamation-circle"></span> '.$success_message.'</div>';
			}

			foreach ($definitions as $fieldname => $definition) {
				if (is_string($definition)) {
					$html .= $definition;
				} else {
					$html .= $this->_renderField($form, $fieldname, $input, $definitions, $definition['field']);
				}
			}

			// submit button
			$html .= '<div class="box box-bottom box-right"><a href="#" class="button button-strong js-submit"><span class="fa fa-check-circle fa-fw"></span> '.$save_button.'</a></div>';

			$html .= '</form>';

			return $html;
		});
	}

	protected function _renderField($form, $fieldname, $input, $definitions, $definition) {
		$type = $definition[0];

		$html = '';

		// generate the default field html
		$definition[0] = $fieldname;

		// native element of \Morrow\Form
		if (method_exists($form, $type)) {
			$html .= call_user_func_array(array($form, $type), $definition);
		} elseif (isset(self::$user_fieldnames[$type])) {
			$dummy_form = new self::$user_fieldnames[$type]($input, [], $definitions);
			$html .= call_user_func_array(array($dummy_form, $type), $definition);
		} else {
			throw new \Exception('Field element "'.$type.'" is unknown.');
		}

		return $html;
	}
}
