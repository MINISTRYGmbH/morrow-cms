<?php

namespace app\features\Authentication_AddUser\models;
use Morrow\Factory;
use Morrow\Debug;

// wenn jeder container eine eigene ID hat, wie macht man dann ein update (weil ja für Untercontainer neue IDs vergeben werden)
// das problem wäre, wenn zwei User das gleiche Element bearbeiten, dann kann ein User, nachdem der andere gespeichert hat, selbst nicht mehr speichern, weil ja die ID des im Moment bearbeiteten Elements gar nicht existiert.
// jeder Container sollte referenzierbar sein
// oder ist jeder Container eigentlich ein Objekt? Welches wie ein Array angesprochen werden kann?

/*
Anforderungen
--------------

* <item></item><item></item> soll pflegbar sein
* einfacher Zugriff auf Daten eines Formulars
* sollte nur möglich sein, per get() Objekte mit einer ID zu bekommen

*/

class Api {
	public static function run($data) {

		//$bm = Factory::load('Benchmark');
		//$bm->start();
		$data = new Data('../app/features/Authentication_AddUser/data.xml', '/morrowcms');

		$dummy = [
			'tests' => [
				'characters' => '"\'<>&',
				'to_change' => 'not_updated',
			],
		];

		try {
			$id = $data->append('/logs', 'entry', $dummy);
			/*
			oder
			$id = $data->get('/logs/entry')->after('entry', $dummy);
			*/

			$id2 = $data->after('/logs/entry[1]', 'entry', $dummy);
			//$data->append('/logs', 'entry', [], ['idref' => $id]);
			//$data->append('/logs', 'entry', [], ['idref' => $id2]);
			//$data->append('/logs', 'entry', 'dfdf');

			Debug::dump($data->get('/logs/entry[1]')->id);

			$new = $data->get('/logs/entry[1]')->getValues();
			$new['tests']['to_change'] = 'updated';
			$data->update(Data::id($id), 'entry', $new);
			/*
			oder
			$data->get(Data::id($id))->update([
				'first' => 'updated'
			]);
			*/

			Debug::dump($data->get('/logs/entry[last()]')->id);

			//$data->delete('/logs/item[3]');
			//$data->delete("//*[@id='$id']");
			//$data->delete(Data::id($id));

			Debug::dump($data->get('/logs')->getValues());
			Debug::dump($data->get('/logs')->__toString());
			//Debug::dump($data->dump('/logs/item', false));
			//Debug::dump($data->dump('/logs/item', true));
			//Debug::dump($bm->get());
			die();

			header('Content-Type: application/xml');
			echo $data->saveXML();
			die();
		} catch (\Exception $e) {
			echo '<pre>'.$e.'</pre>';
		}

		//$data['created_at'] = 12;
		//$data['status'] = 'invited';
		//Debug::dump($data);die();

		try {
			//$db->users->insert($data);
		} catch (\Exception $e) {
			throw new \Exception('Could not invite user.');
		}
	}
}

class Data extends \DOMDocument {
	protected $_path;
	protected $_xpath;
	protected $_root_node;

	public function __construct($path, $root_node = '', $version = '1.0', $encoding = 'utf-8') {
		parent::__construct($version, $encoding);
		$this->registerNodeClass('DOMElement', 'app\features\Authentication_AddUser\models\DOMElementFacade');

		$this->preserveWhiteSpace = false;
		$this->load($path);
		$this->_path = $path;
		$this->_xpath = new \DOMXpath($this);
		$this->_root_node = $root_node;
	}

	/*
	public function get($xpath) {
		$nodes = $this->_query($xpath);

		// first import the found nodes into a new DOMDocument
		$doc = new \DOMDocument('1.0');
		$doc->loadXML("<root></root>");
		$xpath = new \DOMXpath($doc);

		foreach ($nodes as $node) {
			$node = $doc->importNode($node, true);
			$doc->documentElement->appendChild($node);
		}

		// then lets find all idrefs and replace them
		$idrefs = $xpath->query('//*[@idref]');

		foreach ($idrefs as $idref) {
			$id = $idref->getAttribute('idref');
			$el = $this->_query($this->id($id))->item(0);

			$el = $doc->importNode($el, true);
			$idref->parentNode->replaceChild($el, $idref);
		}

		return $doc->firstChild->childNodes;
	}
	*/

	public function getAll($xpath) {
		return $this->_query($xpath);
	}

	public function get($xpath) {
		// return last result (allows to after('/logs/entry') )
		$results = $this->_query($xpath);
		return $results->item($results->length-1);
	}

	public function dump($xpath, $resolve_references = false) {
		if ($resolve_references) {
			$results = $this->get($xpath);
		} else {
			$results = $this->_query($xpath);
		}

		return array_map(array($results->item(0)->ownerDocument, 'saveXML'), iterator_to_array($results));
	}

	public static function id($id) {
		return "//*[@id='$id']";
	}

	public function prepend($xpath, $tagname, $data) {
		return $this->_modify('prepend', $xpath, $tagname, $data);
	}

	public function append($xpath, $tagname, $data) {
		return $this->_modify('append', $xpath, $tagname, $data);
	}

	public function before($xpath, $tagname, $data) {
		return $this->_modify('before', $xpath, $tagname, $data);
	}

	public function after($xpath, $tagname, $data) {
		return $this->_modify('after', $xpath, $tagname, $data);
	}

	public function update($xpath, $tagname, $data) {
		return $this->_modify('update', $xpath, $tagname, $data);
	}

	/*
	Returns count of deleted items
	*/
	public function delete($xpath) {
		$targets = $this->query($xpath);
		foreach ($targets as $target) {
			$target->parentNode->removeChild($target);
		}
		return $targets->length;
	}

	protected function _query($xpath) {
		$query = $this->_xpath->query($this->_root_node . $xpath);
		if ($query->length === 0) {
			throw new \Exception('xpath target not found');
		}
		return $query;
	}

	/*
	Returns id
	*/
	protected function _modify($action, $xpath, $tagname, $data) {
		$query = $this->_query($xpath);
		$target = $query->item(0);

		if (is_scalar($data)) {
			$node = $this->createElement($tagname, $data);
		} else {
			// htmlentities recursively
			array_walk_recursive($data, function(&$v) {
				$v = htmlentities($v);
			});

			$node = $this->createElement($tagname, null);
			$node = $this->createNode($node, $tagname, $data);
		}


		if ($target->getAttribute('id') !== '') {
			$id = $target->getAttribute('id');
			$node->setAttribute('id', $id);
		} else {
			$id = uniqid('id_', true);
			$node->setAttribute('id', $id);
		}

		if ($action === 'prepend') {
			$target->insertBefore($fragment, $target->firstChild);
		} elseif ($action === 'append') {
			$target->appendChild($node);
		} elseif ($action === 'before') {
			$target->parentNode->insertBefore($node, $target);
		} elseif ($action === 'after') {
			$target->parentNode->appendChild($node);
		} elseif ($action === 'update') {
			$target->parentNode->replaceChild($node, $target);
		}

		return $id;
	}

	public function createNode($node, $tagname, $data) {
		foreach ($data as $element => $value) {
			$element = is_numeric( $element ) ? $tagname : $element;

			$child = $this->createElement($element, (is_array($value) ? null : $value));
			$node->appendChild($child);

			if (is_array($value)) {
				$this->createNode($child, $tagname, $value, []);
			}
		}

		return $node;
	}
}

class DOMElementFacade extends \DOMElement {
	// to get ID attribute
	public function __get($member) {
		return $this->getAttribute($member);
	}

	public function getItem($offset) {
		return $this->getElementsByTagName('item')->item($offset);
	}

	public function getText() {
		return $this->textContent;
	}

	public function __toString() {
		return implode('', array_map(array($this->ownerDocument, 'saveXML'), iterator_to_array($this->childNodes)));
	}

	public function getValues($nodes = null) {
		if ($nodes === null) {
			$nodes = iterator_to_array($this->childNodes);
		} else {
			$nodes = iterator_to_array($nodes);
		}

		$returner = array();

		$position_flag = false;
		if (isset($nodes[0]) && isset($nodes[1]) && $nodes[0]->nodeName === $nodes[1]->nodeName) {
			$position_flag = true;
		}

		foreach ($nodes as $position=>$node) {
			// check if the next item as the same name
			$nodename = $position_flag ? $position : $node->nodeName;
			$returner[$nodename] = [];

			if ($node->hasChildNodes()) {
				foreach ($node->childNodes as $subnode) {

					if ($subnode->nodeType === XML_TEXT_NODE) {
						$returner[$nodename] = $subnode->wholeText;
					} else {
						$returner[$nodename] = $this->getValues($node->childNodes);
					}
				}
			}
		}

		return $returner;
	}

}
