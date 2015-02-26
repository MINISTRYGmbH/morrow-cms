<?php

namespace app\features\Core;
use Morrow\Factory;
use Morrow\Debug;

class Pre_Core {
	public static $user_fieldnames;

	public static function addElement($fieldname, $namespace) {
		self::$user_fieldnames[$fieldname] = $namespace;
	}

	public function run($dom) {
		// register xml data handler
		Factory::load('Event')->on('data.xml.get', function($event) {
			$doc = Factory::load('\app\features\Core\DOMDocument');
			return $doc->documentElement;
		});

		// init the data xml class
		$doc = Factory::load('\app\features\Core\DOMDocument');

		try {
			$doc->load(ROOT_PATH . 'data/data.xml');
		} catch (\Exception $e) {
			file_put_contents(ROOT_PATH . 'data/data.xml', '<?xml version="1.0" encoding="utf-8"?><cms version="1.0"></cms>');
			$doc->load(ROOT_PATH . 'data/data.xml');
		}

		$doc->registerNodeClass('DOMElement', 'app\features\Core\DOMElement');
		$doc->preserveWhiteSpace = false;
		$doc->xpath = new \DOMXpath($doc);

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

			// create validator rules and default values
			foreach ($definitions as $fieldname => $definition) {
				if (isset($definition['validator'])) {
					$rules[$fieldname] = $definition['validator'];
				}
			}

			// add CSRF protection
			$csrftoken = Factory::load('Security')->getCSRFToken();
			$definitions['csrf_token'] = [
				'validator' => ['required', 'csrf_token'],
				'field' => ['hidden', $csrftoken],
			];

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
						if (!is_array($api)) $api = [$api];

						// secure arguments for use in success message
						$api = array_map('htmlentities', $api);

						// POST-REDIRECT-GET pattern
						Factory::load('Session')->setFlash('success_message', vsprintf($success, $api));
						Factory::load('Url')->redirect(Factory::load('Page')->get('page.relative'));
					} catch (\Exception $e) {
						$error_message = $e->getMessage() . '<br /><small>' . $e->getFile() . ' ('.$e->getLine().')</small>';
					}

				} else {
					$error_message = 'Please correct the marked fields <small>(' . implode(', ', array_keys($errors)) . ')</small>.';
					// trigger form failure event
				}
			} else {
				// create validator rules and default values
				foreach ($definitions as $fieldname => $definition) {
					if (isset($definition['default'])) {
						$input[$fieldname] = $definition['default'];
					}
				}

				// added multiple submit protection
				$definitions['multisubmit_token'] = [
					'validator' => ['required'],
					'field' => ['hidden', uniqid()],
				];
			}

			// generate form instance
			$form = Factory::load('\app\features\Core\Form', $input, $errors, $definitions);

			$html = '<form method="post">';
			$html .= $form->hidden('sent', 'true');

			// show global error notice
			if (isset($error_message)) {
				$html .= '<div class="message message-error message-form"><span class="fa fa-exclamation-circle"></span> '.$error_message.'</div>';
			}

			$success_message = Factory::load('Session')->getFlash('success_message');
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

		// functionality to validate and render a complete form
		Factory::load('Event')->on('mail.send', function($event, $data) {
			Debug::dump(Factory::load('Config')->get('mail'));
			$mail = Factory::load('Mail', Factory::load('Config')->get('mail'));
			$mail->AddAddress($data[0]);
			$mail->Subject = $data[1];
			$mail->Body    = preg_replace("|^\t+|m", "", trim($data[2]));
			return $mail->Send(true);
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
