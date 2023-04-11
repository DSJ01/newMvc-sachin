<?php

class Block_Core_Layout extends Block_Core_Abstracts{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/layout/1columns.phtml');
		$this->prepareChildren();
	}

	public function prepareChildren()
	{
		$header = new Block_Html_Header();
		$this->addChilde('header',$header);

		$message = new Block_Html_Message();
		$this->addChilde('message', $message);

		$content = new Block_Html_Content();
		$this->addChilde('content',$content);

		$leftSidebar = new Block_Html_Leftsidebar();
		$this->addChilde('leftsidebar', $leftSidebar);

		$rightSidebar = new Block_Html_Rightsidebar();
		$this->addChilde('rightsidebar', $rightSidebar);

		$footer = new Block_Html_Footer();
		$this->addChilde('footer', $footer);

		// $head = new Block_Html_Head();
		// $this->addChilde('head', $head);
	}

	public function createBlock($block)
	{
		$block = 'Block_' .$block;
		$blockClass = new $block;
		return $blockClass; 
	}
}