<?php

namespace app\features\Authentication_ListUsers\models;
use Morrow\Factory;
use Morrow\Debug;

class Api {
	public static function run() {
		$db = Factory::load('\MongoClient')->selectDB('cms');
		$data = $db->users->find();
		return iterator_to_array($data);
	}
}
