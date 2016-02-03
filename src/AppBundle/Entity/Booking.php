<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"live" = "Live", "period" = "Period"})
 * @ORM\Table(name="Booking")
 */
abstract class Booking 
{        /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    protected $id;
         
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    protected $startDate;
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    protected $endDate;
    
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $draft;         
    
    
    /**
     * Get start date
     *
     * @return datetime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }     

    /**
     * Set address
     *
     * @param datetime $startDate
     *
     * 
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
       
    }

    /**
     * Get enddate
     *
     * @return datetime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }     

    /**
     * Set enddate
     *
     * @param datetime $endDate
     *
     * 
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
       
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
     * Set draft
     *
     * 
     *
     * 
     */
    public function setDraft($draft)
    {
        
        $this->draft = $draft;
        
        
    }
  

    /**
     * Get draft
     *
     * @return boolean
     */
    public function getDraft()
    {
        return $this->draft;
    }
    
    
    
}
