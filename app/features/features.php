<?php

$features = [
	'~^login$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Authentication\\EmailPassword'],
		],
	],
	'~^authorization/users$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Authorization\\Users'],
		],
	],
	'~^authorization/groups$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Authorization\\Groups'],
		],
	],
	'~^authorization/permissions$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Authorization\\Permissions'],
		],
	],
	'~^developer/api$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Developer\\API'],
		],
	],
	'~^developer/definitions$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Developer\\Definitions'],
		],
	],
	'~^developer/database$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Developer\\Database'],
		],
	],
	'~^developer/html-elements$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Developer\\HTMLElements'],
		],
		'#nav-sub' => [
			['action' => 'append', 'class' => '\\app\\features\\Dummy\\NavSub'],
		],
	],
	

	'~^(?!login).+$~i' => [
		'#nav-main' => [
			['action' => 'append', 'class' => '\\app\\features\\Dummy\\NavMain'],

			['action' => 'append', 'class' => '\\app\\features\\Authorization\\Headline'],
			['action' => 'append', 'class' => '\\app\\features\\Authorization\\Users_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Authorization\\Groups_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Authorization\\Permissions_Button'],

			['action' => 'append', 'class' => '\\app\\features\\Developer\\Headline'],
			['action' => 'append', 'class' => '\\app\\features\\Developer\\API_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Developer\\Definitions_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Developer\\Database_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Developer\\HTMLElements_Button'],
		],
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Pages\\Error404', 'config' => ['if_does_not_exist' => '//*[@id="content"]/*', 'redirect' => 'login']],
		],
	],
];

foreach ($features as $regex => $feature) {
	// ... modify here
}

return $features;
