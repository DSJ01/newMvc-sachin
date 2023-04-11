<?php
require_once 'Model/Core/session.php';

#addMessage
#getMessage
#clerMessag
/**
 * 
 */
class Model_Core_Message
{
	protected $session = null;
	const SUCCESS = 'success';
	const FAILURE = 'failure';

	public function getSession()
	{
		if ($this->session) {
			return $this->session;
		}
		$session = new Model_Core_Session();
		return $this->session = $session;
	}

		
	public function addMessages($message,$type= self::SUCCESS)
	{
		if ($this->getSession()) {
			$messages = $this->getMessages();
		}

			$messages[$type] = $message;
			$this->getSession()->set('message',$messages);
	}

	public function getMessages()
	{
		if (!$this->getSession()->has('message')) {
			return [];
		}
		return $this->getSession()->get('message');
	}

	public function clearMessages()
	{
		$this->getSession()->set('message',[]);
	}
}

?>