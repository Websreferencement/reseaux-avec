<?php

namespace App\Sidebar;

use App\Model\AbstractWidget;

class NavigationSidebar extends AbstractWidget
{

	public function getTemplate()
	{
		return 'navigation.html.twig';
	}

	public function getName()
	{
		return 'navigation';
	}

	public function initialize()
	{
		return;
	}
}