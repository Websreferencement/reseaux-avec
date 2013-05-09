<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MenuType extends AbstractType
{
	/**
	 * @var ContainerInterface $container
	 */
	private $container;

	/**
	 * Build forms
	 * 
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', 'text', array(
				'label' => 'Nom de votre menu'
			))
			->add('parent', 'entity', array(
				'label' => 'Menu parent',
				'class' => 'App\\Entity\\Menu',
				'required' => false
			))
			->add('page', 'entity', array(
				'label' => 'Page de ce menu',
				'class' => 'App\\Entity\\Page'
			));
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
	 * Return the menu name
	 * 
	 * @return string
	 */
	public function getName()
	{
		return 'menu';
	}
}