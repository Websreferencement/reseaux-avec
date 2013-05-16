<?php

namespace App\Widget;

use App\Model\AbstractWidget;
use App\Entity\Contact;

class ContactWidget extends AbstractWidget
{

	public function getTemplate()
	{
		return 'contact.html.twig';
	}

	public function getName()
	{
		return 'contact';
	}

	public function initialize()
	{
		$contact = new Contact();

		$form = $this->container
			->get('knp_rad.form.manager')
			->createBoundObjectForm($contact, 'new');

		$this->args->set('contact_form', $form->createView());

		return;
	}
}