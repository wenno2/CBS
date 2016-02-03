<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * @ORM\Entity
 * 
 */
class Live extends Booking
{   
    
    /**
     * @ORM\ManyToOne(targetEntity="FamilyMember", inversedBy="lives")
     * @ORM\JoinColumn(name="FM_id", referencedColumnName="id", nullable=true)
     * @Assert\NotNull(message = "You must specify a member.")     
     */    
    private $member;
    
    /**
     * @ORM\ManyToMany(targetEntity="Person")
     * @ORM\JoinTable(name="live_people",
     *      joinColumns={@ORM\JoinColumn(name="live_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=false)}
     *      )
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one person"    
     * )
     */
    
    private $people;
    
        
    
    public function __construct() {
        $this->people = new ArrayCollection();
    }
    
    

    /**
     * Set member
     *
     * @param FamilyMember $member
     *
     * 
     */
    public function setMember(FamilyMember $member = null)
    {
        $this->member = $member;

    }

    /**
     * Get member
     *
     * @return FamilyMember
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Add person
     *
     * @param Person $person
     *
     * 
     */
    public function addPerson(Person $person)
    {
        $this->people[] = $person;

    }

    /**
     * Remove person
     *
     * @param \AppBundle\Entity\Person $person
     */
    public function removePerson(Customer $person)
    {
        $this->people->removeElement($person);
    }

    /**
     * Get people
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeople()
    {
        return $this->people;
    }
        
    
    
    
}
