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
use AppBundle\Validator\Constraints as HSAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * @ORM\Entity
 * 
 *
 * @HSAssert\PeriodHighSeasonCheck
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PeriodRepository")
*/
class Period extends Booking
{        
       
    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="periods")
     * @ORM\JoinColumn(name="Contact_id", referencedColumnName="id")
     * @Assert\NotBlank()
     * 
     * 
     */

    private $contact;
        
     /**
     * Set contact
     *
     * @param Contact $contact
     *
     * 
     */
    public function setContact(Contact $contact)
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
    
    
    
    ///**
    // * @Assert\Callback
     //*/
    //public function highSeasonsCheck(ExecutionContextInterface $context)
    //{
        
        //
        //echo $this->startDate('M');
        /*
        $startDateF = date_format($this->startDate, 'M');
        $endDateF = date_format($this->endDate, 'M');
          */              
        
        
        // Check if startdate and enddate months are high season months
        /*
        $SDCount = $this->get('Doctrine')
        ->getRepository('AppBundle:HighSeason')
        ->getMonthCount($startDateF);

        $EDCount = $this->get('Doctrine')
        ->getRepository('AppBundle:HighSeason')
        ->getMonthCount($endDateF);
        
        if ($SDCount < 1) {
                $context->buildViolation("Start date not in high season month")
                        ->atPath('startDate')
                        ->addViolation();
        }

        if ($EDCount < 1) {
                $context->buildViolation("End date not in high season month")
                        ->atPath('endDate')
                        ->addViolation();
        }
        */
        /*
        $context->buildViolation($startDateF)
                ->atPath('startDate')
                ->addViolation();
        
        $context->buildViolation($endDateF)
                ->atPath('endDate')
                ->addViolation();
          */    
        
        // validate 
            /*
            $context->buildViolation('The end date has not been entered!')
                ->atPath('endDate')
                ->addViolation();

            $context->buildViolation('The start date has not been entered!')
                ->atPath('startDate')
                ->addViolation();
        */
    //}
    
    
     /**
     * Check if booking is in a high season 
     *
     * @return boolean
     */
    public function checkIfInHighSeason(){
        
        
        
        
        
    }
    
    
}
