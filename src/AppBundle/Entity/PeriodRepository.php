<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * Description of PeriodRepository
 *
 * @author james
 */
class PeriodRepository extends EntityRepository {
    
    
    
    public function getContactPBCount($contactID){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(B.id) FROM AppBundle:Period B JOIN B.contact C WHERE C.id = :contactid AND B.draft = FALSE')->setParameter('contactid', $contactID);
        
        
        return $query->getSingleScalarResult();
    }
    
    public function getOtherContactPBCount($contactID){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(B.id) FROM AppBundle:Period B JOIN B.contact C WHERE C.id != :contactid AND B.draft = FALSE')->setParameter('contactid', $contactID);
        
        
        return $query->getSingleScalarResult();
    }

    public function getMatchCount($startDate, $endDate){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(B.id) FROM AppBundle:Period B WHERE B.startDate = :SD AND B.endDate = :ED AND B.draft = FALSE')->setParameter('SD', $startDate)->setParameter('ED', $endDate);
        
        
        return $query->getSingleScalarResult();
    }    
 
    public function getMatchCountByID($id, $startDate, $endDate){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(B.id) FROM AppBundle:Period B WHERE B.id = :id AND B.startDate = :SD AND B.endDate = :ED AND B.draft = FALSE')->setParameter('id', $id)->setParameter('SD', $startDate)->setParameter('ED', $endDate);
        
        
        return $query->getSingleScalarResult();
    }    

    public function setPBToDraft($id){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('UPDATE AppBundle:Period B SET B.draft = TRUE WHERE B.id = :ID')->setParameter('ID', $id);
        $rows = $query->execute();
                        
    }
    
    public function getContactPBID($contactID){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT B.id FROM AppBundle:Period B JOIN B.contact C WHERE C.id = :contactid AND B.draft = FALSE')->setParameter('contactid', $contactID);
        
        
        return $query->getSingleScalarResult();
    }    
    
    public function getOCPBs($Id){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT PB FROM AppBundle:Period PB JOIN PB.contact C WHERE C.id != :Id AND PB.draft = FALSE')->setParameter('Id', $Id);
        $OCPBs = $query->getResult();
        
        
        return $OCPBs;
        
    } 
    
    public function getOCPBByID($Id){
        
        $em = $this->getEntityManager();        
        $query = $em->createQuery('SELECT PB FROM AppBundle:Period PB WHERE PB.id = :Id')->setParameter('Id', $Id);
        $OCPB = $query->getSingleResult();
        
        
        return $OCPB;
    }
    
    public function getPBsForContact($Id){
        
        
        $em = $this->getEntityManager();        
        $query = $em->createQuery('SELECT PB FROM AppBundle:Period PB JOIN PB.contact C WHERE C.id = :Id AND PB.draft = FALSE')->setParameter('Id', $Id);
        $PBs = $query->getResult();
        
        
        return $PBs;
        
    }    

    public function getPBForContact($Id){
        
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT PB.startDate FROM AppBundle:Period PB JOIN PB.contact C WHERE C.id = :Id AND PB.draft = FALSE')->setParameter('Id', $Id);
        $PB = $query->getSingleResult();
        
        var_dump($PB);
        die();
        return $PB;
        
    }
    
}
