<?php

$features = [
	'~^.*$~i' => [
		['class' => '\\app\\features\\Authentication_LoginRedirect\\Pre_Redirect'],
		['class' => '\\app\\features\\Authentication_ListUsers\\Pre_RegisterApi'],
		['class' => '\\app\\features\\Authentication_AddUser\\Pre_RegisterApi'],
		['class' => '\\app\\features\\Authentication_EditUser\\Pre_RegisterApi'],
		['class' => '\\app\\features\\Authentication_DeleteUser\\Pre_RegisterApi'],
	],
	
	'~^login$~i' => [
		['class' => '\\app\\features\\Authentication_LoginPassword\\Page', 'action' => 'append', 'selector' => '#content'],
		['class' => '\\app\\features\\Authentication_LoginGoogle\\Button', 'action' => 'append', 'selector' => '#alternative-logins'],
		['class' => '\\app\\features\\Authentication_LoginFacebook\\Button', 'action' => 'append', 'selector' => '#alternative-logins'],
		['class' => '\\app\\features\\Authentication_LoginTwitter\\Button', 'action' => 'append', 'selector' => '#alternative-logins'],
	],
	'~^authentication/users$~i' => [
		['class' => '\\app\\features\\Authentication_ListUsers\\Page', 'action' => 'append', 'selector' => '#content'],
		['class' => '\\app\\features\\Authentication_EditUser\\Button'],
		['class' => '\\app\\features\\Authentication_AddUser\\Button', 'action' => 'append', 'selector' => '#content-nav'],
	],
	'~^authentication/users/add$~i' => [
		['class' => '\\app\\features\\Authentication_AddUser\\Page', 'action' => 'append', 'selector' => '#content'],
	],
	'~^authentication/users/edit$~i' => [
		['class' => '\\app\\features\\Authentication_EditUser\\Page', 'action' => 'append', 'selector' => '#content'],
		['class' => '\\app\\features\\Authentication_DeleteUser\\Button', 'action' => 'append', 'selector' => '#content-nav'],
	],
	'~^authorization/groups$~i' => [
		['class' => '\\app\\features\\Authorization\\Groups', 'action' => 'append', 'selector' => '#content'],
	],
	'~^authorization/permissions$~i' => [
		['class' => '\\app\\features\\Authorization\\Permissions', 'action' => 'append', 'selector' => '#content'],
	],
	'~^developer/api$~i' => [
		['class' => '\\app\\features\\Developer_API\\Page', 'action' => 'append', 'selector' => '#content'],
	],
	'~^developer/definitions$~i' => [
		['class' => '\\app\\features\\Developer_Definitions\\Page', 'action' => 'append', 'selector' => '#content'],
	],
	'~^developer/database$~i' => [
		['class' => '\\app\\features\\Developer_Database\\Page', 'action' => 'append', 'selector' => '#content'],
	],
	'~^developer/html-elements$~i' => [
		['class' => '\\app\\features\\Developer_HTMLElements\\Page', 'action' => 'append', 'selector' => '#content'],
		['class' => '\\app\\features\\Dummy\\NavSub', 'action' => 'append', 'selector' => '#nav-sub'],
	],
	'~^(?!login|api).+$~i' => [
		['class' => '\\app\\features\\Dummy\\NavMain', 'action' => 'append', 'selector' => '#nav-main'],

		['class' => '\\app\\features\\Authorization\\Headline', 'action' => 'append', 'selector' => '#nav-main'],
		['class' => '\\app\\features\\Authentication_ListUsers\\Button', 'action' => 'append', 'selector' => '#nav-main'],
		['class' => '\\app\\features\\Authorization\\Groups_Button', 'action' => 'append', 'selector' => '#nav-main'],
		['class' => '\\app\\features\\Authorization\\Permissions_Button', 'action' => 'append', 'selector' => '#nav-main'],

		['class' => '\\app\\features\\Developer_Headline\\Headline', 'action' => 'append', 'selector' => '#nav-main'],
		['class' => '\\app\\features\\Developer_API\\Button', 'action' => 'append', 'selector' => '#nav-main'],
		['class' => '\\app\\features\\Developer_Definitions\\Button', 'action' => 'append', 'selector' => '#nav-main'],
		['class' => '\\app\\features\\Developer_Database\\Button', 'action' => 'append', 'selector' => '#nav-main'],
		['class' => '\\app\\features\\Developer_HTMLElements\\Button', 'action' => 'append', 'selector' => '#nav-main'],

		['class' => '\\app\\features\\Pages\\Error404', 'config' => ['if_does_not_exist' => '//*[@id="content"]/*', 'redirect' => 'login'], 'action' => 'append', 'selector' => '#content'],
	],
	'~^api$~i' => [
		['class' => '\\app\\features\\Api\\Api', 'action' => 'append', 'selector' => '#content'],
	],
];

foreach ($features as $regex => $feature) {
	// ... modify here
}

return $features;
