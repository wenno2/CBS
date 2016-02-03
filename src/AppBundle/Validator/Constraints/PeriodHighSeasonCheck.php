<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of HighSeasonCheck
 *
 * @author james
 */


/**
 * @Annotation
 */
class PeriodHighSeasonCheck extends Constraint {
    //put your code here
    
    public function validatedBy()
    {
        return 'PHSconflicts';
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
   
}

