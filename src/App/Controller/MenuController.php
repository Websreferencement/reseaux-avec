<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Knp\RadBundle\Controller\Controller;
use App\Entity\Menu;

class MenuController extends Controller
{
	public function indexAction()
	{
		$menus = $this->getRepository('App\Entity\Menu')
			->findAll();

		return array(
			'menus' => $menus
		);
	}

	public function newAction(Request $request)
	{
		$menu = new Menu();

		$form = $this->createBoundObjectForm($menu, 'new');

		if($form->isBound() and $form->isValid()){
				$this->persist($menu);
				$this->flush();

				$this->addFlash('Menu '.$menu->getName().' créé avec succés !');

				return $this->redirectToRoute('app_menu_index');	
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function editAction($id)
	{
		$menu = $this->findOr404('App:Menu', array('id' => $id));

		$form = $this->createBoundObjectForm($menu, 'edit');

		if($form->isBound() and $form->isValid()){
			$this->persist($menu);
			$this->flush();

			$this->addFlash('Menu '.$menu->getName().' édité avec succés !');

			return $this->redirectToRoute('app_menu_index');
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function deleteAction($id)
	{
		$menu = $this->findOr404('App:Menu', array('id' => $id));

		$this->remove($menu);
		$this->flush();

		$this->addFlash('Menu '.$menu->getName().' supprimé !');

		return $this->redirectToRoute('app_menu_index');
	}

}