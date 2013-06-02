<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PageType extends AbstractType
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
        $secu = $this->container->get('security.context');

        $context = $this->container->get('security.context');

		$builder
			->add('title', 'text', array(
				'attr' => array(
					'class' => 'input-large'
				),
				'label' => 'Titre de la page'
			))
			->add('content', 'ckeditor', array(
				'label' => 'Contenue de cette page'
			))
        ;

        if ($context->isGranted('ROLE_SUPER_ADMIN')) {
            $builder 
                ->add('widgets', 'widget')
                ->add('sidebar', 'sidebar')
                ->add('headTitle', 'text', array(
                    'attr' => array(
                        'class' => 'input-large'
                    ),
                    'label' => 'Titre du head'
                ))
                ->add('headDescription', 'textarea', array(
                    'label' => 'Meta description',
                    'required' => false
                ))
                ->add('priority', 'integer', array(
                    'label' => 'Sitemap priorité'
                ))
            ;

        }
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
		return 'page';
	}
}
