<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WidgetType extends AbstractType
{
	/**
	 * @var ContainerInterface $container
	 */
	private $container;

	/**
	 * Get all the available widgets
	 * 
	 * @return array
	 */
	private function getRegisterWidgets()
	{
		$widgetContainer = $this->container->get('app.widget_container');
		$widgets = array();

		foreach($widgetContainer as $w){
			$widgets[$w->getName()] = $w->getName();
		}

		return $widgets;
	}

	/**
	 * Set the default options
	 * 
	 * @param OptionsResolverInterface
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'choices' => $this->getRegisterWidgets(),
			'label' => 'Choisissez les widgets de cette page',
			'multiple' => true,
			'expanded' => true
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
		return 'widget';
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