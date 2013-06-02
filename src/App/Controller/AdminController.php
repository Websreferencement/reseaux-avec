<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;

class AdminController extends Controller
{
	public function indexAction()
	{
		return array();
	}

	public function browseImageAction()
	{
		$request = $this->getRequest();
        $callback = $request->query->get('CKEditorFuncNum');

        // create the upload directory :
        if(!is_dir(__DIR__.'//../../../web/uploaded')){
            mkdir(__DIR__.'//../../../web/uploaded');
        }

        $finder = new Finder();
        $files  = $finder->files()
            ->name('/\.(jpg|jpeg|png|bmp|gif)/i')
            ->in(__DIR__.'//../../../web/uploaded');

        return array(
            'files' => $files,
            'callback' => $callback
        );
	}

	public function uploadImageAction()
	{
		$request = $this->getRequest();

        $callback = $request->query->get('CKEditorFuncNum');
        $file = $request->files->get('upload');
        if(!is_object($file)){
            $message = 'form.ckeditor.no_file';
        } else {
            $validExts = array(
                'jpg', 'jpeg', 'png', 'bmp', 'gif'
            );
            $ext = $file->guessExtension();
            if(!in_array(strtolower($ext), $validExts)){
                $message = 'form.ckeditor.bad_extension';
            } else {
                $file_name = uniqid().'.'.$ext;
                $file->move(__DIR__.'//../../../web/uploaded/', $file_name);
                // Upload file :
                $image = $this->get('image.handling')
                    ->open(__DIR__.'//../../../web/uploaded/'.$file_name);
                if($ext == 'png'){
                    $image = $image->cropResize(900, 600, 'transparent');
                } else {
                    $image = $image->cropResize(900, 600);
                }
                $image->save(__DIR__.'//../../../web/uploaded/'.$file_name);
                $message = '';
            }
        }

        return array(
            'callback' => $callback,
            'message' => $message,
            'file_name' => $file_name
        );
	}

    /**
     * Upload the member list in pdf
     */
    public function uploadMemberListAction()
    {
        $request = $this->getRequest();
        $context = $this->get('security.context');

        if (!$request->getMethod() == 'POST') {
            $this->addFlash('error', 'Invalid method !');
            return $this->redirectToRoute('app_admin_index');
        }

        if (!$context->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas la permission !');
            return $this->redirectToRoute('app_admin_index');
        }
        

        $pdf = $request->files->get('member_list');
        if (null === $pdf) {
            $this->addFlash('error', 'Aucun fichier n\'a était envoyé !');
            return $this->redirectToRoute('app_admin_index');
        }

        if (!is_dir(__DIR__.'/../../../web/pdf-upload')) {
            mkdir(__DIR__.'/../../../web/pdf-upload');
        }

        if ($pdf->getMimeType() != 'application/pdf') {
            $this->addFlash('error', 'Le format de fichier est invalide !
                un fichier au fomat ".pdf" doit être envoyé');
            return $this->redirectToRoute('app_admin_index');
        }

        if (file_exists(__DIR__.'/../../../web/pdf-upload/member_list.pdf')) {
            unlink(__DIR__.'/../../../web/pdf-upload/member_list.pdf');
        }

        $pdf->move(__DIR__.'/../../../web/pdf-upload', 'member_list.pdf');

        $this->addFlash('success', 'La liste des membres à était mise à jour
            avec succés');
        return $this->redirectToRoute('app_admin_index');
    }

    /**
     * Upload the agenda
     */
   public function uploadAgendaAction()
   {
       $request = $this->getRequest();
       $response = array();
       $context = $this->get('security.context');

       if (!$context->isGranted('ROLE_ADMIN')) {
           $this->addFlash('error', 'Vous n\'avez pas la permission.');
           return $this->redirectToRoute('app_admin_index');
       }

       $pdf = $request->files->get('agenda');
       if (null === $pdf) {
           $this->addFlash('error', 'Aucun fichier n\'a était reçu.');
           return $this->redirectToRoute('app_admin_index');
       }

       if (!is_dir(__DIR__.'/../../../web/pdf-upload')) {
           mkdir(__DIR__.'/../../../web/pdf-upload');
       }

       if ($pdf->getMimeType() != 'application/pdf') {
           $this->addFlash('error', 'Mauvais format ! Un fichier au format
               ".pdf" dot être envoyé');
           return $this->redirectToRoute('app_admin_index');
       }

       if (file_exists(__DIR__.'/../../../web/pdf-upload/agenda.pdf')) {
           unlink(__DIR__.'/../../../web/pdf-upload/agenda.pdf');
       }

       $pdf->move(__DIR__.'/../../../web/pdf-upload', 'agenda.pdf');

       $this->addFlash('success', 'Agenda mise à jour avec succès !');
       return $this->redirectToRoute('app_admin_index');
   } 
}
