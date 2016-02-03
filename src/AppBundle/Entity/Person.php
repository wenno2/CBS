<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"familymember" = "FamilyMember", "contact" = "Contact", "noncontact" = "NonContact", "friend" = "Friend"})
 * @ORM\Table(name="Person")
 */
abstract class Person 
{
        /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */    
    
    protected $id;
    
     /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $firstName;
     /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $surname;
    
    
        /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $address;
    
    
     /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }     

    /**
     * Set address
     *
     * @param string $address
     *
     * 
     */
    public function setAddress($address)
    {
        $this->address = $address;

       
    }
    
     /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
     /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
     /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }    

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * 
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * 
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        
    }
}
