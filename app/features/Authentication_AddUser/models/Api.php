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

		//$bm = Factory::load('Benchmark');
		//$bm->start();
		$data = Factory::load('Event')->trigger('data.get', ROOT_PATH . 'data/data.xml');

		//$temp = new \app\features\Core\DOMDocument(ROOT_PATH . 'data/data.xml');
		//$data = $temp->documentElement;

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

