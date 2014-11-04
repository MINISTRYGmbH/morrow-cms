<?php

$features = [
	'~^permissions/users$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Permissions\\Users'],
		],
	],
	'~^permissions/groups$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Permissions\\Groups'],
		],
	],
	'~^permissions/permissions$~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Permissions\\Permissions'],
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
	'~.+~i' => [
		'#nav-main' => [
			['action' => 'append', 'class' => '\\app\\features\\Dummy\\NavMain'],
		],
		'#nav-main > .navi' => [
			['action' => 'append', 'class' => '\\app\\features\\Permissions\\Headline'],
			['action' => 'append', 'class' => '\\app\\features\\Permissions\\Users_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Permissions\\Groups_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Permissions\\Permissions_Button'],

			['action' => 'append', 'class' => '\\app\\features\\Developer\\Headline'],
			['action' => 'append', 'class' => '\\app\\features\\Developer\\API_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Developer\\Definitions_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Developer\\Database_Button'],
			['action' => 'append', 'class' => '\\app\\features\\Developer\\HTMLElements_Button'],
		],
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Pages\\Error404', 'config' => ['if_does_not_exist' => '//*[@id="content"]/*']],
		],
	],
];

foreach ($features as $regex => $feature) {
	// ... modify here
}

return $features;
