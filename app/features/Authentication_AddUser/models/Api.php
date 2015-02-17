<?php

namespace app\features\Authentication_AddUser\models;
use Morrow\Factory;
use Morrow\Debug;

/*
Anforderungen
--------------
<pages>
	<page id>
		<data>
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
				<data>
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

		$doc = Factory::load('Event')->trigger('data.xml.get');

		$dummy = [
			'characters' => '"\'<>&',
			'to_change' => 'not_updated',
		];

		try {
			$id = $doc->find('./logs')->append('entry', []);

			$entry = $doc->findId($id);
			$entry->setData($dummy);
			$data = $entry->getData();
			$data['to_change'] = 'updated';
			$entry->setData($data);

			$entry->append('foo', 'bar');

			$id2 = $entry->append('foo2', ['bar', 'bar2']);

			// delete tests
			//$doc->deleteId($id2);
			//$doc->deleteAll('//foo2');
			//$doc->delete('//foo2');

			Debug::dump($doc->find('./logs')->__toString());

			die();

			header('Content-Type: application/xml');
			echo $doc->saveXML();
			die();
		} catch (\Exception $e) {
			echo '<pre>'.$e.'</pre>';
		}

		//$doc['created_at'] = 12;
		//$doc['status'] = 'invited';
		//Debug::dump($doc);die();

		try {
			//$db->users->insert($doc);
		} catch (\Exception $e) {
			throw new \Exception('Could not invite user.');
		}
	}
}

