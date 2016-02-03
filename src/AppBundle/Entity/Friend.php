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
 * @ORM\Table(name="Friend")
 */
class Friend extends Person
{
    public function __toString()
    {
        //$name = $this->getFirstName() ." ". $this->getSurname();
        
        $name = $this->getFirstName() ." ". $this->getSurname();
        
        return (string) $name;
    }
    
}