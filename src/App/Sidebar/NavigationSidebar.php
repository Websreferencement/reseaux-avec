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
        $actions = $this->container
            ->get('app.entity.action_repository')
            ->findBy(array(), null, 2);

        $news = $this->container
            ->get('app.entity.news_repository')
           ->findBy(array(), null, 2); 

        $this->args->set('news', $news);
        $this->args->set('actions', $actions);

		return;
	}
}
