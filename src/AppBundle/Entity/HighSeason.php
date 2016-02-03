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
 * @ORM\Table(name="HighSeason")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\HighSeasonRepository")
 */
class HighSeason
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $id;
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     * 
     */
    private $startDate;
    
     /**
     * @ORM\Column(type="datetime", nullable=false)
     * 
     */
    private $endDate;
    
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
     * Set start date
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
    
}