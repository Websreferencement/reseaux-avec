<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageType extends AbstractType
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
			->add('name', 'text', array(
				'label' => 'Nom de l\'image',
				'attr' => array(
					'class' => 'input-large'
				)
			))
			->add('alt', 'text', array(
				'label' => 'Texte alternatif',
				'attr' => array(
					'class' => 'input-large'
				)
			))
			->add('category', 'entity', array(
				'class' => 'App:MediaCategory',
				'label' => 'Catégorie de cette image'
			))
			->add('file', 'image_preview', array(
				'label' => 'Votre image'
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
		return 'image';
	}
}
