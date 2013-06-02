<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ActionType extends AbstractType
{
	/**
	 * @var ContainerInterface $container
	 */
	private $container;

	/**
	 * Build the form
	 * 
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title', 'text', array(
				'label' => 'Titre de l\'action'
			))
			->add('description', 'textarea', array(
				'label' => 'Courte description de cette action'
			))
			->add('content', 'ckeditor', array(
				'label' => 'Contenue de votre action'
			))
		;
	}

	/**
	 * Set the container
	 * 
	 * @param ContainerInterface $container
	 */
	public function setContainer(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * Identify this form
	 * 
	 * @return string
	 */
	public function getName()
	{
		return 'action';
	}
}
