<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContactType extends AbstractType
{

	/**
	 * Build the form
	 * 
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', 'text', array(
				'label' => 'Votre nom, société*',
				'attr' => array(
					'class' => 'input-large'
				),
				'required' => true
			))
			->add('email', 'email', array(
				'label' => 'Votre adresse email*',
				'required' => true
			))
			->add('phone', 'string', array(
				'label' => 'Votre numéros de téléphone',
				'required' => false
			))
			->add('message', 'text', array(
				'label' => 'Votre messge*',
				'required' => true
			))
		;
	}

	/**
	 * Identify this form
	 * 
	 * @return string
	 */
	public function getName()
	{
		return 'contact';
	}
}