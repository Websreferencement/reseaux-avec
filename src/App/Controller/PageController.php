<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Page;

class PageController extends Controller
{
	public function indexAction()
	{
		$datas = $this->get('app.helper.datatable')
			->setRepository($this->get('app.entity.page_repository'))
			->setEntity('Page');

		return array(
			'datas' => $datas
		);
	}

	public function newAction(Request $request)
	{
		$page = new Page();

		$form = $this->createBoundObjectForm($page, 'new');

		if($form->isBound() and $form->isValid()){
			$this->persist($page);
			$this->flush();

			$this->addFlash('info', 'Page '.$page.' créée avec succés !');

			return $this->redirectToRoute('app_page_index');
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function editAction($id)
	{
		$page = $this->findOr404('App:Page', array('id' => $id));

		$form = $this->createBoundObjectForm($page, 'edit');

		if($form->isBound() and $form->isValid()){
			$this->persist($page);
			$this->flush();

			$this->addFlash('info', 'Page '.$page.' éditée avec succés !');

			return $this->redirectToRoute('app_page_index');
		}

		return array(
			'form' => $form->createView(),
			'data' => $page
		);
	}

	public function deleteAction($id)
	{
		$page = $this->findOr404('App:Page', array('id' => $id));

		$this->remove($page);
		$this->flush();

		$this->addFlash('info', 'Page '.$page.' suprimée avec succés !');

		return $this->redirectToRoute('app_page_index');
	}

	public function homeAction($uri)
	{
		$uri = '/'.$uri;

		$page = $this->findOr404('App:Page', array('uri' => $uri));

		return array(
			'page' => $page,
			'uri' => $uri
		);
	}
}