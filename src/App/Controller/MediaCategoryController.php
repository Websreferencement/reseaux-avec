<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;
use App\Entity\MediaCategory;


class MediaCategoryController extends Controller
{

	public function indexAction()
	{
		$datas = $this->get('app.helper.datatable')
			->setRepository($this->get('app.entity.media_category_repository'))
			->setEntity('MediaCategory');

		return array(
			'datas' => $datas
		);
	}

	public function newAction(Request $request)
	{
		$category = new MediaCategory();

		$form = $this->createBoundObjectForm($category, 'new');

		if($form->isBound() and $form->isValid()){
			$this->persist($category);
			$this->flush();

			$this->addFlash('info', 'La catégorie '.$category.' créée avec succés !');

			return $this->redirectToRoute('app_mediaCategory_index');
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function editAction($id)
	{
		$category = $this->findOr404('App:MediaCategory', array('id' => $id));

		$form = $this->createBoundObjectForm($category, 'edit');

		if($form->isBound() and $form->isValid()){
			$this->persist($category);
			$this->flush();

			$this->addFlash('info', 'La catégorie '.$category.' éditée avec succés !');

			return $this->redirectToRoute('app_mediaCategory_index');
		}

		return array(
			'form' => $form->createView(),
			'data' => $category
		);
	}

	public function deleteAction($id)
	{
		$category = $this->findOr404('App:MediaCategory', array('id' => $id));

		$this->remove($category);
		$this->flush();

		$this->addFlash('info', 'La category '.$category.' suprimée avec succés !');

		return $this->redirectToRoute('app_mediaCategory_index');
	}

}