<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VideoPreviewType extends AbstractType
{
	public function set(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'class' => 'video-textarea'
		));
	}

	public function buildView(FormView $view, FormInterface $form, array $options)
	{
		$parentData = $form->getParent()->getdata();

		if (null === $parentData->getEmbed()){
			return;
		}

		$view->set('video_embed', $parentData->getEmbed());
	}

	public function getName()
	{
		return 'video_preview';
	}

	public function getParent()
	{
		return 'textarea';
	}
}