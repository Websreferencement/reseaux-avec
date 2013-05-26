<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class VideoType extends AbstractType
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
				'label' => 'Nom de cette vidéo',
				'attr' => array(
					'class' => 'input-large'
				)
            ))
            ->add('alt', 'text', array(
                'label' => 'Texte alternatif'
            ))
            ->add('content', 'textarea', array(
                'label' => 'Code de cette vidéo'
            ))
            ->add('category', 'entity', array(
                'class' => 'App:MediaCategory',
                'label' => 'Catégorie de cette vidéo'
            ))
            ->add('file', 'file', array(
                'label' => 'Miniature de la vidéo'
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
		return 'video';
	}
}
