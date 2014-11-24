<?php

namespace app\features\Authentication;
use Morrow\Factory;
use Morrow\Debug;

class Edit_User_Buttons extends _Default {
	public function run($dom) {
		$nodes = $dom->query('xpath://*[@id="content"]//tr');

		foreach ($nodes as $i => $node) {
			$id = $node->getAttribute('data-id');
			if ($id === '') {
				$content = '<td></td>';
			} else {
				$content = '<td><a href="authentication/users/edit?id='.$id.'" class="button button-small"><span class="fa fa-pencil fa-fw"></span> Editieren</a></td>';
			}
			
			$fragment = $dom->createDocumentFragment();
			$fragment->appendXML($content);
			$node->insertBefore($fragment, $node->firstChild);
		}

		return '';
	}
}