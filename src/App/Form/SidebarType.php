<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SidebarType extends AbstractType
{
	/**
	 * @var ContainerInterface $container
	 */
	private $container;

	/**
	 * Get all the available sidebars
	 * 
	 * @return array
	 */
	private function getRegisterSidebars()
	{
		$sidebarContainer = $this->container->get('app.sidebar_container');
		$sidebars = array();

		foreach($sidebarContainer as $w){
			$sidebars[$w->getName()] = $w->getName();
		}

		return $sidebars;
	}

	/**
	 * Set the default options
	 * 
	 * @param OptionsResolverInterface
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'choices' => $this->getRegisterSidebars(),
			'label' => 'Choisissez la sidebar de cette page'
		));
	}

	/**
	 * Inject the container
	 * 
	 * @param ContainerInteface $container
	 */
	public function setContainer(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * Return the name
	 */
	public function getName()
	{
		return 'sidebar';
	}

	/**
	 * Returns the extended types
	 * 
	 * @return string
	 */
	public function getParent()
	{
		return 'choice';
	}
}