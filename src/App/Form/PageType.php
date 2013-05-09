<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
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
			->add('title', 'text', array(
				'attr' => array(
					'class' => 'input-large'
				),
				'label' => 'Titre de la page'
			))
			->add('content', 'textarea', array(
				'label' => 'Contenue de cette page'
			))
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