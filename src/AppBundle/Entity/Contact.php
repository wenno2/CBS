<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * A contact must exist before a family member
 * 
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Contact")
 */
class Contact extends FamilyMember
{
     /**
     * @ORM\OneToMany(targetEntity="NonContact", mappedBy="contact")
     */
    protected $nonContacts;
    
     
    
    /**
     * @ORM\OneToMany(targetEntity="Period", mappedBy="contact")
     */
    private $periods;
    
    
    public function __construct()
    {
        $this->nonContacts = new ArrayCollection();
        $this->periods = new ArrayCollection();
     }    
    
    public function __toString()
    {
        $name = $this->getFirstName() ." ". $this->getSurname();
        
        //$name = $this->getFirstName() ." ". $this->getSurname() . " (" . $this->getAddress() . ")" ;
        
        return (string) $name;
    }
    

    /**
     * Add member
     *
     * @param FamilyMember $member
     *
     * 
     */
    public function addMember(FamilyMember $member)
    {
        $this->members[] = $member;

    }

    /**
     * Remove member
     *
     * @param FamilyMember $member
     */
    public function removeMember(FamilyMember $member)
    {
        $this->members->removeElement($member);
    }

    /**
     * Get members
     *
     * @return Collection
     */
    public function getMembers()
    {
        return $this->members;
    }
}
