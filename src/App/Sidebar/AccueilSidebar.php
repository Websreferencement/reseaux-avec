<?php

namespace App\Sidebar;

use App\Model\AbstractWidget;

class AccueilSidebar extends AbstractWidget
{

	public function getTemplate()
	{
		return 'accueil.html.twig';
	}

	public function getName()
	{
		return 'accueil';
	}
}