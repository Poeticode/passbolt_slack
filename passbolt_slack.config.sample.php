<?php
// Include main file.
require_once (APP . 'Plugin' . DS . 'PassboltSlack' . DS . 'Lib' . DS . 'Event' . DS . 'PassboltSlack.php');

App::uses('CakeEventManager', 'Event');

// Configuration for PassboltSlack.
Configure::write('PassboltSlack', [
		'token' => 'T03GS3H9Q/B6DD2HQE8/moM03jCRZoLXNVfc4g9XztxK',
		'channel' => '#security',
		'username' => 'Slackbolt',
		'icon_emoji' => ':cop:',
	]);

// Attach listeners.
CakeEventManager::instance()->attach(new PassboltSlack());