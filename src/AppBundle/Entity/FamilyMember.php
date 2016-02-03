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
 * @ORM\Table(name="FamilyMember")
 * @ORM\MappedSuperclass
 */
abstract class FamilyMember extends Person
{
    /**
     * @ORM\OneToMany(targetEntity="Live", mappedBy="member")
     */
    private $lives;
    
    public function __construct()
    {
        $this->lives = new ArrayCollection();
    }  
    
}
