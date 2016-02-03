<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/AppBundle/Form/DataTransformer/IssueToNumberTransformer.php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\FamilyMember;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class NameToIDTransformer implements DataTransformerInterface
{
    private $manager;
    private $id;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($issue)
    {
         if (null === $issue) {
            return '';
        }        
        $this->id = $issue->getId();
               
        return $issue->getFirstName()." ".$issue->getSurname()."(".$issue->getAddress().")";
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $issueNumber
     * @return Issue|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($issueNumber)
    {
                
        // no issue number? It's optional, so that's ok
        if (!$issueNumber) {
            return;
        }            
                  
        
        $re1='((?:[a-z][a-z]+))';	# Word 1
        $re2='( )';	# White Space 1
        $re3='((?:[a-z][a-z]+))';	# Word 2
        $re4='(\\(.*\\))';	# Round Braces 1

        $c=preg_match_all("/".$re1.$re2.$re3.$re4."/is", $issueNumber, $matches);


        if ($c)
        {
            // if name and address matches frmat
            $word1=$matches[1][0];
            $ws1=$matches[2][0];
            $word2=$matches[3][0];
            $rbraces1=$matches[4][0];
            //var_dump( "($word1) ($ws1) ($word2) ($rbraces1) \n");


              $parts1 = split('[(]', $issueNumber);
                
            $address = rtrim($parts1[1], ')');

            $parts = preg_split('/\s+/', $parts1[0]);



            if ($this->id) {

            $issue = $this->manager
                ->getRepository('AppBundle:FamilyMember')
                // query for the issue with this id
                ->findOneBy(array('id' => $this->id, 'firstName' => $parts[0],'surname' => $parts[1],'address' => $address));
            } else {
                $issue = $this->manager
                ->getRepository('AppBundle:FamilyMember')
                // query for the issue with this id
                ->findOneBy(array('firstName' => $parts[0],'surname' => $parts[1], 'address' => $address));
            }
        } else {
            $issue = null;
        }
        
        
      
        
        
        
        
        if (null === $issue) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $issueNumber
            ));
        }

        return $issue;
    }
}