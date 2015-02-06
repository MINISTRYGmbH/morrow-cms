<?php

namespace app\features\Authentication_AddUser\models;
use Morrow\Factory;
use Morrow\Debug;

class Api {
	public static function run($data) {

		$start = memory_get_usage();
		$data = new Data('../app/features/Authentication_AddUser/data.xml');

		try {
			$data->append('/morrowcms/logs', 'item', ['last' => 'place', 'foo' => 'bar']);
			$id = $data->before('/morrowcms/logs/item[1]', 'item', ['first' => 'place']);
			$data->append('//logs', 'item', $_SERVER);

			//$data->delete('//logs/item[3]');
			//$data->delete("//*[@id='$id']");
			//$data->delete(Data::id($id));

			//Debug::dump($data->get(Data::id($id)));
			//die();

			header('Content-Type: application/xml');
			echo $data->saveXML();
			die();
		} catch (\Exception $e) {
			echo '<pre>'.$e.'</pre>';
		}



		$end = memory_get_usage();
		echo round(($end-$start)/1024/1024, 3) . ' MB (Peak: '.round(memory_get_peak_usage()/1024/1024, 3).' MB, Limit:'.ini_get('memory_limit').')';
		die();


		$data['created_at'] = 12;
		$data['status'] = 'invited';
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

	public function __construct($path, $version = '1.0', $encoding = 'utf-8') {
		parent::__construct($version, $encoding);

		$this->preserveWhiteSpace = false;
		$this->load($path);
		$this->_path = $path;
		$this->_xpath = new \DOMXpath($this);
	}

	public function get($xpath) {
		$query = $this->query($xpath);
		$target = $query->item(0);

		return $this->xml2array($this->saveHtml($target));
	}

	public static function id($id) {
		return "//*[@id='$id']";
	}

	protected function xml2array($xml,$recursive = false) {
		if (!$recursive ) { $array = simplexml_load_string ($xml); }
		else { $array = $xml; }

		$newArray = array();
		$array = $array ;

		foreach ($array as $key => $value) {
			$value = (array) $value;

			if (isset($value[0])) { $newArray[$key] = trim($value[0]); }
			else { $newArray[$key][] = $this->xml2Array($value, true) ; }
		}

		return $newArray;
	}

	public function query($xpath) {
		return $this->_xpath->query($xpath);
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

	public function replace($xpath, $tagname, $data) {
		return $this->_modify('replace', $xpath, $tagname, $data);
	}

	/*
	Returns count of deleted items
	*/
	public function delete($xpath) {
		$targets = $this->query($xpath);
		if ($targets->length === 0) {
			throw new \Exception('xpath target not found');
		}
		foreach ($targets as $target) {
			$target->parentNode->removeChild($target);
		}
		return $targets->length;
	}

	/*
	Returns id
	*/
	protected function _modify($action, $xpath, $tagname, $data) {
		$query = $this->query($xpath);
		if ($query->length === 0) {
			throw new \Exception('xpath target not found');
		}
		$target = $query->item(0);

		// htmlentities recursively
		array_walk_recursive($data, function(&$v) {
			$v = htmlentities($v);
		});

		$node = $this->createElement($tagname, null);
		$node = $this->createNode($node, $tagname, $data);

		$id = $node->getAttribute('id');

		if ($action === 'prepend') {
			$target->insertBefore($fragment, $target->firstChild);
		} elseif ($action === 'append') {
			$target->appendChild($node);
		} elseif ($action === 'before') {
			$target->parentNode->insertBefore($node, $target);
		} elseif ($action === 'after') {
			$target->parentNode->appendChild($node);
		} elseif ($action === 'replace') {
			$target->parentNode->replaceChild($node, $target);
		}

		return $id;
	}

	public function createNode($node, $tagname, $data) {
		$id = uniqid('id_', true);
		$node->setAttribute('id', $id);

		foreach ($data as $element => $value) {
			$element = is_numeric( $element ) ? $tagname : $element;

			$child = $this->createElement($element, (is_array($value) ? null : $value));
			$node->appendChild($child);

			if (is_array($value)) {
				$this->createNode($child, $tagname, $value);
			}
		}

		return $node;
	}
}

