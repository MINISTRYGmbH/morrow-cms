<?php

$features = [
	'~.+~i' => [
		'#content' => [
			['action' => 'append', 'class' => '\\app\\features\\Pages\\Error404', 'config' => ['if_does_not_exist' => '//*[@id="content"]/*']],
		],
	],
];

foreach ($features as $regex => $feature) {
	// ... modify here
}

return $features;
