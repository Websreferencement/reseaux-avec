<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;

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

            if ($this->getFlashBag()->get('contact_widget')) {
                // send email message
                $from = $this->container
                    ->getParameter('mailer_from');

                $message = $this->createMessage(
                    'new_contact', 
                    array(
                        'contact' => $contact
                    ))
                    ->setFrom($from)
                    ->setTo($contact->getEmail());

                $this->send($message);

			    $this->addFlash(
                    'info', 
                    'Votre message à bien était envoyé'
                ); 
                return $this->redirectToRoute('frontend', array(
                    'uri' => 'contact'
                ));
            }

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
