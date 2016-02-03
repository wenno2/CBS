<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * Description of HighSeasonRepository
 *
 * @author james
 */
class HighSeasonRepository extends EntityRepository {
    
    
    
    public function getMonthCount($month){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(HS.id) FROM AppBundle:HighSeason HS WHERE HS.month = :month')->setParameter('month', $month);
        
        
        return $query->getSingleScalarResult();
    }
    
    public function getHighSeasons(){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT HS FROM AppBundle:HighSeason HS');
        $highseasons = $query->getResult();
        
        return $highseasons;
        
    }

    public function getHighSeasonByID($Id){
            
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT HS FROM AppBundle:HighSeason HS WHERE HS.id = :Id')->setParameter('Id', $Id);
        $highseason = $query->getSingleResult();
        
        return $highseason;
        
    }
    
}
