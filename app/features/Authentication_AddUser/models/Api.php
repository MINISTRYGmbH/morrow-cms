<?php

namespace app\features\Authentication_AddUser\models;
use Morrow\Factory;
use Morrow\Debug;

/*
Anforderungen
--------------

<files>
	<file id="a1">
		<data>

		</data>
	</file>
</files>
<pages>
	<page id>
		<data id>
			<description>gdgdf</description>
			<description2>gdgdf</description>
			<description3>gdgdf</description>
			<description4>gdgdf</description>
			<description4>
				<option value="@idref:a1">products/foobar.jpg</option>
				<option value="@idref:a2">products/foobar2.jpg</option>
			</description>

		</data>
		<main id>
			<block1 id>
				<data id>
					<foo>gdf</foo>
					<bar>gfdgd</bar>
				</data>
			</block1>
		</main>
	<page>
</pages>

*/

class Api {
	public static function run($data) {

		//$bm = Factory::load('Benchmark');
		//$bm->start();
		$data = new Data('../app/features/Authentication_AddUser/data.xml', '/morrowcms');

		$dummy = [
			'characters' => '"\'<>&',
			'to_change' => 'not_updated',
		];

		try {
			$id = $data->find('./logs')->append('entry', []);

			$entry = $data->findId($id);
			$entry->setData($dummy);
			$new = $entry->getData();
			$new['to_change'] = 'updated';
			$entry->setData($new);
			$entry->append('foo', 'bar');
			$entry->append('foo2', ['bar', 'bar2']);

			Debug::dump($data->find('./logs')->__toString());
			Debug::dump($data->find('//foo')->getContent());
			Debug::dump($data->find('//foo2')->getContent());

			// delete tests
			//$data->delete('/logs/entry[last()]');
			//$data->delete("//*[@id='$id']");
			//$data->delete(Data::id($id));

			Debug::dump($data->find('./logs')->__toString());

			//Debug::dump($bm->find());
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
	public $xpath;

	public function __construct($path, $version = '1.0', $encoding = 'utf-8') {
		parent::__construct($version, $encoding);
		$this->registerNodeClass('DOMElement', 'app\features\Authentication_AddUser\models\DOMElementFacade');

		$this->preserveWhiteSpace = false;
		$this->load($path);
		$this->_path = $path;
		$this->xpath = new \DOMXpath($this);
	}

	public function findAll($xpath) {
		return $this->xpath->query($xpath, $this->documentElement);
	}

	public function findId($id) {
		return $this->find("//*[@id='$id']", $this);
	}

	public function find($xpath) {
		$results = $this->xpath->query($xpath, $this->documentElement);
		return $results->length === 0 ? null : $results->item($results->length-1);
	}

	/*
	Returns count of deleted items
	*/
	public function delete($xpath) {
		$targets = $this->xpath->query($xpath, $this->documentElement);
		foreach ($targets as $target) {
			$target->parentNode->removeChild($target);
		}
		return $targets->length;
	}
}

class DOMElementFacade extends \DOMElement {
	// to get ID attribute
	public function __get($member) {
		return $this->getAttribute($member);
	}

	public function findAll($xpath) {
		return $this->xpath->query($xpath, $this->documentElement);
	}

	public function findId($id) {
		return $this->find("//*[@id='$id']", $this);
	}

	public function find($xpath) {
		$results = $this->ownerDocument->xpath->query($xpath, $this);
		return $results->length === 0 ? null : $results->item($results->length-1);
	}

	public function __toString() {
		$this->ownerDocument->formatOutput = true;

		return "\n" . implode('', array_map(array($this->ownerDocument, 'saveXML'), iterator_to_array($this->childNodes)));
	}

	public function getData() {
		$data_child = $this->find('./data');
		return $data_child === null ? [] : $data_child->getContent();
	}

	// returns if data node was created
	public function setData($data) {
		$data_child = $this->find('./data');
		if ($data_child === null) {
			$this->_modify('append', 'data', $data, false);
			return true;
		}

		$data_child->_modify('update', 'data', $data, false);
		return false;
	}

	public function getContent($nodes = null) {
		if ($nodes === null) {
			$nodes = iterator_to_array($this->childNodes);
		} else {
			$nodes = iterator_to_array($nodes);
		}

		// return simple text nodes
		if (isset($nodes[0]) && $nodes[0]->nodeType === XML_TEXT_NODE) return $this->textContent;

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
						$returner[$nodename] = $this->getData($node->childNodes);
					}
				}
			}
		}

		return $returner;
	}

	public function prepend($tagname, $data = []) {
		return $this->_modify('prepend', $tagname, $data);
	}

	public function append($tagname, $data = []) {
		return $this->_modify('append', $tagname, $data);
	}

	public function before($tagname, $data = []) {
		return $this->_modify('before', $tagname, $data);
	}

	public function after($tagname, $data = []) {
		return $this->_modify('after', $tagname, $data);
	}

	protected function _modify($action, $tagname, $data, $set_id = true) {
		if (is_scalar($data)) {
			$node = $this->ownerDocument->createElement($tagname, $data);
		} else {
			// htmlentities recursively
			array_walk_recursive($data, function(&$v) {
				$v = htmlentities($v);
			});

			$node = $this->ownerDocument->createElement($tagname, null);
			$node = $this->createNode($node, $tagname, $data);
		}

		if (is_array($data) && $set_id) {
			if ($this->getAttribute('id') !== '') {
				$id = $this->getAttribute('id');
				$node->setAttribute('id', $id);
			} else {
				$id = uniqid('id_', true);
				$node->setAttribute('id', $id);
			}
		}

		if ($action === 'prepend') {
			$this->insertBefore($fragment, $this->firstChild);
		} elseif ($action === 'append') {
			$this->appendChild($node);
		} elseif ($action === 'before') {
			$this->parentNode->insertBefore($node, $this);
		} elseif ($action === 'after') {
			$this->parentNode->appendChild($node);
		} elseif ($action === 'update') {
			$this->parentNode->replaceChild($node, $this);
		}

		if (isset($id)) return $id;
	}

	public function createNode($node, $tagname, $data) {
		foreach ($data as $element => $value) {
			$element = is_numeric($element) ? 'i' : $element;

			$child = $this->ownerDocument->createElement($element, (is_array($value) ? null : $value));
			$node->appendChild($child);

			if (is_array($value)) {
				$this->createNode($child, $tagname, $value, []);
			}
		}

		return $node;
	}
}
