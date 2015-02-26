<?php

return [
// debug
	'debug.output.screen'			=> strtotime('+1 day'),
	'debug.output.file'				=> strtotime('-1 day'),

	// mailer
	'mail.Mailer'					=> 'smtp',
	'mail.From'						=> 'test@example.com',
	'mail.FromName'					=> 'John Doe',
	'mail.WordWrap'					=> 0,
	'mail.Encoding'					=> 'quoted-printable',
	'mail.CharSet'					=> 'utf-8',
	'mail.SMTPAuth'					=> false,
	'mail.Host'						=> 'localhost',
	'mail.Port'						=> 10025,
];
