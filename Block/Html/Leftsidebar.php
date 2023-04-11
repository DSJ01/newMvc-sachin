<?php

/**
 * 
 */
class Block_Html_Leftsidebar extends Block_Core_Abstracts
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/leftsidebar.phtml');
	}
}

?>