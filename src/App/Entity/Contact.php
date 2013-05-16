<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 */
class Contact
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string $name
	 *
	 * @ORM\Column(type="string", length=250)
	 */
	private $name;

	/**
	 * @var string $email
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $email;

	/**
	 * @var string $phone
	 *
	 * @ORM\Column(type="string", length=25)
	 */
	private $phone;

	/**
	 * @var string $message
	 *
	 * @ORM\Column(type="text")
	 */
	private $message;

	/**
	 * Get name
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Contact
	 */
	public function setName($name)
	{
		$this->name = $name;
	
		return $this;
	}

	/**
	 * Get phone
	 * 
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;
	}
	
	/**
	 * Set phone
	 *
	 * @param string $phone
	 * @return Contact
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;
	
		return $this;
	}

	/**
	 * Get email
	 * 
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	
	/**
	 * Set email
	 *
	 * @param string $email
	 * @return Contact
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	
		return $this;
	}

	/**
	 * Get message
	 * 
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}
	
	/**
	 * Set message
	 *
	 * @param string $message
	 * @return Contact
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	
		return $this;
	}

	public function __toString()
	{
		return $this->getName();
	}
}