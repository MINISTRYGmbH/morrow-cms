<?php

return [
// debug
	'debug.output.screen'			=> strtotime('+1 day'),
	'debug.output.file'				=> strtotime('-1 day'),

// mongodb
	'mongodb.uri'					=> 'mongodb://test:test@ds051750.mongolab.com:51750/cms',

	// db
	'db.driver'						=> 'mysql',
	'db.host'						=> 'localhost',
	'db.db'							=> 'morrow_cms',
	'db.user'						=> 'root',
	'db.pass'						=> '',
	'db.encoding'					=> 'utf8',
];
