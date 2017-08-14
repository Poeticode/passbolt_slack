<?php
App::uses('CakeEventListener', 'Event');
require_once (APP . 'Plugin' . DS . 'PassboltSlack' . DS . 'Lib' . DS . 'Slack' . DS . 'Slack.php');

class PassboltSlack implements CakeEventListener {

	/**
	 * Implements implementedEvents().
	 * @return array
	 */
	public function implementedEvents() {
		return array(
			'Model.User.afterRegister' => 'afterUserRegister',
			'Controller.ShareController.afterShare' => 'afterShareNotification'
		);
	}

	/**
	 * afterUserRegister callback.
	 * @param $event
	 */
	public function afterUserRegister($event) {
		if (Configure::read('PassboltSlack') && Configure::read('debug') == 0) {
			// Retrieve data.
			$data = $event->data['data'];
			$name = $data['Profile']['first_name'] . ' ' . $data['Profile']['last_name'];
			$email = $data['User']['username'];
			$url = Router::url('/', true );

			// Get message configuration.
			Configure::write('Slack', Configure::read('PassboltSlack'));

			// Push on slack.
			Slack::send("$name ($email) registered to <$url|Passbolt Demo>");
		}
	}

	public function afterShareNotification($event) {
		if (Configure::read('PassboltSlack') && Configure::read('debug') == 0) {

			$recipient_name = $event->data['recipient'];
			$sender_name = $event->data['sender'];
			$resource_name = $event->data['resource'];

			// Get message configuration.
			Configure::write('Slack', Configure::read('PassboltSlack'));

			// Slack::send("Testing this!");
			Slack::send("Hey $recipient_name! $sender_name shared $resource_name with you.");

		}
	}
}
