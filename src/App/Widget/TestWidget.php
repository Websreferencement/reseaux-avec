<?php

namespace App\Widget;

use App\Model\AbstractWidget;

class TestWidget extends AbstractWidget
{

	public function getTemplate()
	{
		return 'test.html.twig';
	}

	public function getName()
	{
		return 'test';
	}
}