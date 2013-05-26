<?php

namespace App\Controller;


use Knp\RadBundle\Controller\Controller;
use App\Entity\Image;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends Controller 
{
	public function indexAction()
	{
		$datas = $this
			->get('app.helper.datatable')
			->setRepository($this->get('app.entity.image_repository'))
			->setEntity('Image');

		return array(
			'datas' => $datas
		);
	}

	public function newAction(Request $request)
	{
		$image = new Image();

		$form = $this->createBoundObjectForm($image, 'new');

		if($form->isBound() and $form->isValid()){
			$this->persist($image);
			$this->flush();

			$this->addFlash('info', 'L\'image '.$image.' créée avec succés !');

			return $this->redirectToRoute('app_image_index');
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function editAction($id)
	{
		$image = $this->findOr404('App:Image', array('id' => $id));

		$form = $this->createBoundObjectForm($image, 'edit');

		if($form->isBound() and $form->isValid()){
			$this->persist($image);
			$this->flush();

			$this->addFlash('info', 'L\'image '.$image.' éditée avec succés !');

			return $this->redirectToRoute('app_image_index');
		}

		return array(
			'form' => $form->createView(),
			'data' => $image
		);
	}

	public function deleteAction($id)
	{
		$image = $this->findOr404('App:Image', array('id' => $id));

		$this->remove($image);
		$this->flush();

		$this->addFlash('info', 'L\'image '.$image.' suprimée avec succés !');

		return $this->redirectToRoute('app_image_index');
	}
}