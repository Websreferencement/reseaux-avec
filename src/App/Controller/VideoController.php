<?php

namespace App\Controller;


use Knp\RadBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Video;

class VideoController extends Controller
{

	public function indexAction()
	{
		$datas = $this
			->get('app.helper.datatable')
			->setRepository($this->get('app.entity.video_repository'))
			->setEntity('Video');

		return array(
			'datas' => $datas
		);
	}

	public function newAction(Request $request)
	{
		$video = new Video();

		$form = $this->createBoundObjectForm($video, 'new');

		if($form->isBound() and $form->isValid()){
			$this->persist($video);
			$this->flush();

			$this->addFlash('info', 'La vidéo '.$video.' créée avec succés !');

			return $this->redirectToRoute('app_video_index');
		}

		return array(
			'form' => $form->createView()
		);
	}

	public function editAction($id)
	{
		$video = $this->findOr404('App:Video', array('id' => $id));

		$form = $this->createBoundObjectForm($video, 'edit');

		if($form->isBound() and $form->isValid()){
			$this->persist($video);
			$this->flush();

			$this->addFlash('info', 'La vidéo '.$video.' éditée avec succés !');

			return $this->redirectToRoute('app_video_index');
		}

		return array(
			'form' => $form->createView(),
			'data' => $video
		);
	}

	public function deleteAction($id)
	{
		$video = $this->findOr404('App:Video', array('id' => $id));

		$this->remove($video);
		$this->flush();

		$this->addFlash('info', 'La vidéo '.$video.' suprimée avec succés !');

		return $this->redirectToRoute('app_video_index');
	}
}
