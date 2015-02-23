<?php

namespace app\features\Core;
use Morrow\Factory;
use Morrow\Debug;

class DOMElement extends \DOMElement {
	public function __get($member) {
		return $this->getAttribute($member);
	}

	public function findAll($xpath) {
		return $this->ownerDocument->xpath->query($xpath, $this);
	}

	public function findId($id) {
		return $this->find("//*[@id='$id']", $this);
	}

	public function find($xpath) {
		$results = $this->ownerDocument->xpath->query($xpath, $this);
		return $results->length === 0 ? null : $results->item($results->length-1);
	}

	public function deleteAll($xpath) {
		$targets = $this->findAll($xpath);
		foreach ($targets as $target) {
			$target->parentNode->removeChild($target);
		}
		$this->save();
		return $targets->length;
	}

	public function deleteId($id) {
		$target = $this->findId($id);
		$target->parentNode->removeChild($target);
		$this->save();
	}

	public function delete($xpath) {
		$target = $this->find($xpath);
		$target->parentNode->removeChild($target);
		$this->save();
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
			if ($node->getAttribute('id') !== '') {
				$id = $node->getAttribute('id');
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

		$this->save();
		
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

	
	public function save() {
		// save the XML data
		$this->ownerDocument->save($this->ownerDocument->documentURI);
	}
}
