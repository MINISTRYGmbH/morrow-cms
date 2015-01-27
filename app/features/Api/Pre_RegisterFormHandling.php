<?php

namespace app\features\Api;
use Morrow\Factory;
use Morrow\Debug;

class Pre_RegisterFormHandling {
	public function run($dom) {
		Factory::load('Event')->on('form.handle', function($event, $data) {
			list($api_url, $definitions) = $data;
			
			// possibility for a user hook 
			$definitions = Factory::load('Event')->trigger('form.definition.modify', $definitions);
			
			// create validator rules
			foreach ($definitions as $fieldname => $definition) {
				if (isset($definition['validator'])) {
					$rules[$fieldname] = $definition['validator'];
				}
			}

			// validate
			$input  = Factory::load('Input')->get();
			$errors = [];

			if (isset($input['sent'])) {
				if ($data = Factory::load('Validator')->filter($input, $rules, $errors, true)) {
					// possibility for a user hook 
					$data = Factory::load('Event')->trigger('form.data.before_save.modify', $data);

					Debug::dump($data);
					die();

					$api	= Factory::load('\Api');
					//$user	= $api->execute($api_url);
				} else {
					// trigger form failure event
				}
			}
			
			// generate form instance
			$form = Factory::load('\cms\Form', $input, $errors, $definitions);

			$html = '<form action="' . Factory::load('Page')->get('path.absolute') . '" method="post">';
			$html .= $form->hidden('sent', 'true');
			
			// show global error notice
			if (count($errors) > 0) {
				$html .= '<div class="message message-error message-form"><span class="fa fa-exclamation-circle"></span> Bitte korrigiere die rot markierten Felder.</div>';
			}
			
			foreach ($definitions as $fieldname => $definition) {
				$html .= '<div class="form-row">';
				
				if (is_string($definition)) {
					$html .= $definition;
				} else {
					// render label
					array_unshift($definition['label'], $fieldname);
					$html .= call_user_func_array([$form, 'label'], $definition['label']);

					$html .= $this->_renderField($form, $fieldname, $definition['field']);
				}
				
				$html .= '</div>';
			}
			
			// submit button
			$html .= '<div class="box box-bottom box-right"><a href="" class="button button-strong js-submit"><span class="fa fa-check fa-fw"></span>Benutzer hinzufügen</a></div>';
			
			$html .= '</form>';
			
			return $html;
		});
	}
	
	protected function _renderField($form, $fieldname, $definition) {
		$type = $definition[0];
		
		$html = '';
		
		// the prefix
		if (isset($definition['prefix'])) {
			$html .= '<div class="form-extension-prefix">'. $definition['prefix'] .'</div>';
		}
		
		// generate the default field html
		$definition[0] = $fieldname;
		$html .= call_user_func_array(array($form, $type), $definition);
		
		// the suffix
		if (isset($definition['suffix'])) {
			$html .= '<div class="form-extension-suffix">'. $definition['suffix'] .'</div>';
		}
		
		return $html;
	}
}