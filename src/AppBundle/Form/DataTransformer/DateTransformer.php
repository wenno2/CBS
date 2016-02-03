<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/AppBundle/Form/DataTransformer/IssueToNumberTransformer.php
namespace AppBundle\Form\DataTransformer;

//use AppBundle\Entity\FamilyMember;
//use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use \DateTime;
use \DateInterval;

class DateTransformer implements DataTransformerInterface
{
    //private $manager;
    //private $id;

    public function __construct()
    {
        
       // ObjectManager $manager 
       // $this->manager = $manager;
    }

    /**
     * Transform a datetime to a date string.
     *
     * @param  DateTime|null $datetime
     * @return date
     */
    public function transform($datetime)
    {
         if (null === $datetime) {            
             
             // returning null, because it expects a DateTime instance
            return null;
        }        
                                       
        
        return $datetime;                
    }

    /**
     * Transforms a string date to a datetime object.
     *
     * @param  string $date
     * @return Issue|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($date)
    {                                
        
        if (!$date) {
            return;
        }            
        
        // add 10 hours onto date
        $date->add(new DateInterval('PT23H59M59S'));
                

        return $date;
    }
}