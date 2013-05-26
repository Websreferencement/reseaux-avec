<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;
use App\Entity\Contact;

class ContactController extends Controller
{

	public function indexAction()
	{
		$datas = $this
			->get('app.helper.datatable')
			->setRepository($this->get('app.entity.contact_repository'))
			->setEntity('Contact');

		return array(
			'datas' => $datas
		);
	}

	public function newAction(Request $request)
	{
		$contact = new Contact();

		$form = $this->createBoundObjectForm($contact, 'new');

		if($form->isBound() and $form->isValid()){
			$this->persist($contact);
			$this->flush();

			$this->addFlash('info', 'Le contact '.$contact.' créé avec succés !');

			return $this->redirectToRoute('app_contact_index');
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function editAction($id)
	{
		$contact = $this->findOr404('App:Contact', array('id' => $id));

		$form = $this->createBoundObjectForm($contact, 'edit');

		if($form->isBound() and $form->isValid()){
			$this->persist($contact);
			$this->flush();

			$this->addFlash('info', 'Le contact '.$contact.' édité avec succés !');

			return $this->redirectToRoute('app_contact_index');
		}

		return array(
			'form' => $form->createView(),
			'data' => $contact
		);
	}

	public function deleteAction($id)
	{
		$contact = $this->findOr404('App:Contact', array('id' => $id));

		$this->remove($contact);
		$this->flush();

		$this->addFlash('info', 'Contact '.$contact.' suprimé avec succés !');

		return $this->redirectToRoute('app_contact_index');
	}
}