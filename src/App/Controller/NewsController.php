<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;
use App\Entity\News;

class NewsController extends Controller
{
	public function indexAction()
	{
		$news = $this->getRepository('App:News')
			->findAll();

		return array(
			'news' => $news
		);
	}

	public function newAction(Request $request)
	{
		$news = new News();

		$form = $this->createBoundObjectForm($news, 'new');

		if($form->isBound() and $form->isValid()){
			$this->persist($news);
			$this->flush();

			$this->addFlash('info', 'Actualité '.$news.' créée avec succés !');

			return $this->redirectToRoute('app_news_index');
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function editAction($id)
	{
		$news = $this->findOr404('App:News', array('id' => $id));

		$form = $this->createBoundObjectForm($news, 'edit');

		if($form->isBound() and $form->isValid()){
			$this->persist($news);
			$this->flush();

			$this->addFlash('info', 'Actualité '.$news.' éditée avec succés !');

			return $this->redirectToRoute('app_news_index');
		}

		return array(
			'form' => $form->createView(),
			'data' => $news
		);
	}

	public function deleteAction($id)
	{
		$news = $this->findOr404('App:News', array('id' => $id));

		$this->remove($news);
		$this->flush();

		$this->addFlash('info', 'Actualité '.$news.' suprimée avec succés !');

		return $this->redirectToRoute('app_news_index');
	}

	public function showAction($title)
	{
		
	}
}