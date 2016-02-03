<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="NonContact")
 */
class NonContact extends FamilyMember
{
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="nonContacts")
     * @ORM\JoinColumn(name="Contact_id", referencedColumnName="id", nullable=true)
     */    
    private $contact;
    
    public function __construct()
    {
        
    }  
    
    
    public function __toString()
    {
        //$name = $this->getFirstName() ." ". $this->getSurname();
        
        $name = $this->getFirstName() ." ". $this->getSurname();
        
        return (string) $name;
    }
    
    
    /**
     * Set contact
     *
     * @param Contact $contact
     *
     * 
     */
    public function setContact(Contact $contact = null)
    {
        $this->contact = $contact;


    }

    /**
     * Get contact
     *
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }
}
