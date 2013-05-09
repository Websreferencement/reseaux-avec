<?php
/*
 * This file is a part of réseaux AVEC. Please read
 * the LICENSE and/or README.md files for more informations
 * about this project.
 */
 
namespace App\Model;

/**
 * WidgetInterface
 *
 * Defined the comportment of a standard widget.
 * @author David Jegat <david.jegat@gmail.com>
 */
interface WidgetInterface
{
	/**
	 * All widgets have a name. So give it an explicit name
	 * 
	 * @return string
	 */	
	public function getName();

	/**
	 * Widgets have associated templates located into "App:Widgets". 
	 * you can omit the App:Widgets key. Just put your template name.
	 * 
	 * @return string
	 */
	public function getTemplate();

	/**
	 * This method returns the templates arguments.
	 * 
	 * @return array
	 */
	public function getTemplateArguments();
}