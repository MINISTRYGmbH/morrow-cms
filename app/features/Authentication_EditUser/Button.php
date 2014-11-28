<?php

namespace app\features\Authentication_EditUser;
use Morrow\Factory;
use Morrow\Debug;

class Button {
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