<?php

// If you want to modify defaults for your project (like routing rules), use this file.

return [
// security
	'security.csp.default-src'		=> "'self'",
	'security.csp.script-src'		=> "'self' cdnjs.cloudflare.com",
	'security.csp.img-src'			=> "'self' *.gstatic.com lorempixel.com",
	'security.csp.style-src'		=> "'self' 'unsafe-inline' cdnjs.cloudflare.com fonts.googleapis.com",
	// 'security.csp.media-src'		=> "'self'",
	// 'security.csp.object-src'	=> "'self'",
	// 'security.csp.frame-src'		=> "'self'",
	'security.csp.font-src'			=> "'self' cdnjs.cloudflare.com *.gstatic.com",
	'security.frame_options'		=> "DENY", // (DENY|SAMEORIGIN|ALLOW-FROM uri)
	'security.content_type_options'	=> "nosniff",
	
// routing rules
	'router.routes'					=> [],
	'router.fallback'				=>	function($url) { return '\app\Home'; },
];
