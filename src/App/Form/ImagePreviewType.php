<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImagePreviewType extends AbstractType
{
	public function buildView(FormView $view, FormInterface $form, array $options)
	{
		$parentData = $form->getParent()->getdata();

		if (null === $parentData->getThumbSrc()){
			return;
		}

		$view->set('image_src', $parentData->getThumbSrc());
	}

	public function getName()
	{
		return 'image_preview';
	}

	public function getParent()
	{
		return 'file';
	}
}
