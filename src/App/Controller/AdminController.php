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
        if(!is_dir(__DIR__.'/../../../web/uploaded')){
            mkdir(__DIR__.'/../../../web/uploaded');
        }

        $finder = new Finder();
        $files  = $finder->files()
            ->name('/\.(jpg|jpeg|png|bmp|gif)/i')
            ->in(__DIR__.'/../../../web/uploaded');

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
                $file->move(__DIR__.'/../../../web/uploaded/', $file_name);
                // Upload file :
                $image = $this->get('image.handling')
                    ->open(__DIR__.'/../../../web/uploaded/'.$file_name);
                if($ext == 'png'){
                    $image = $image->cropResize(900, 600, 'transparent');
                } else {
                    $image = $image->cropResize(900, 600);
                }
                $image->save(__DIR__.'/../../../web/uploaded/'.$file_name);
                $message = '';
            }
        }

        return array(
            'callback' => $callback,
            'message' => $message,
            'file_name' => $file_name
        );
	}
}