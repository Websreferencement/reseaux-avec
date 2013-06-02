<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;
use App\Entity\Action;
use Symfony\Component\HttpFoundation\Request;

class ActionController extends Controller
{
	public function indexAction()
	{
		$datas = $this->get('app.helper.datatable')
			->setRepository($this->get('app.entity.action_repository'))
			->setEntity('Action');

		return array(
			'datas' => $datas
		);
	}

	public function newAction(Request $request)
	{
		$action = new Action();

		$form = $this->createBoundObjectForm($action, 'new');

		if($form->isBound() and $form->isValid()){
			$this->persist($action);
			$this->flush();

			$this->addFlash('info', 'Action '.$action.' créée avec succés !');

			return $this->redirectToRoute('app_action_index');
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function editAction($id)
	{
		$action = $this->findOr404('App:Action', array('id' => $id));

		$form = $this->createBoundObjectForm($action, 'edit');

		if($form->isBound() and $form->isValid()){
			$this->persist($action);
			$this->flush();

			$this->addFlash('info', 'Action '.$action.' éditée avec succés !');

			return $this->redirectToRoute('app_action_index');
		}

		return array(
			'form' => $form->createView(),
			'data' => $action
		);
	}

	public function deleteAction($id)
	{
		$action = $this->findOr404('App:Action', array('id' => $id));

		$this->remove($action);
		$this->flush();

		$this->addFlash('info', 'Action '.$action.' suprimée avec succés !');

		return $this->redirectToRoute('app_action_index');
	}

	public function showAction($uri)
	{
		$action = $this->findOr404('App:Action', array('uri' => $uri));

		$page = $this->findOr404('App:Page', array('uri' => '/actions'));

		return array(
			'page' => $page,
			'actions' => $action
		);
	}
}
