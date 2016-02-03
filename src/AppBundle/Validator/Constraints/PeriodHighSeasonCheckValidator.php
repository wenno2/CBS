<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use \DateInterval;



/**
 * Description of PeriodClassValidator
 * 
 * NPB  = New period booking
 * OCPB = Other contact period booking
 *
 * @author james
 */
class PeriodHighSeasonCheckValidator extends ConstraintValidator {
    
    public function __construct($doctrine)
    {
                
        $this->doctrine = $doctrine;
        
    }
    
     public function inNPBHighSeason() {
         
         // check which high season the 
         
     }
    
    
    public function validate($value, Constraint $constraint) {
                        
        
        if ((($value->getStartDate() != null) && ($value->getEndDate() != null)) && ($value->getDraft() == false))
        {
                    
            
            $diff=date_diff($value->getStartDate(),$value->getEndDate());
                $days = $diff->format('%d');
                                
                if ($days != 13) {
                    
                    $this->context->buildViolation("Period not two weeks long")
                        ->atPath('startDate')
                        ->addViolation();
                    
                    
                    $this->context->buildViolation("Period not two weeks long")
                        ->atPath('endDate')
                        ->addViolation();
                } else {
            
        
                    $highseasons = $this->doctrine
                    ->getRepository('AppBundle:HighSeason')
                    ->getHighSeasons();

                     $HSMonths = false;
                     
                  // check if NPB is in a high season
                    // get year                     
                     //$year = $value->getStartDate()->format('y');
                    
                    // year has to be outside of high season 
                    foreach ($highseasons as $highseason) {

                        //var_dump($highseasons);
                            // if there's a date difference for both months then reset and try next high season
                           // $tempDate = clone $HSDate;
                        
                            $HSDate = clone $highseason->getStartDate();
                            $diff=date_diff($highseason->getStartDate(),$highseason->getEndDate());

                            $months = (int)$diff->format('%m');
                            $SDBool = false;
                            $EDBool = false;                    

                            
                            // loop through the date difference/months
                            for ($i = 0; $i <= $months; $i++)
                            {
                                //var_dump($highseasons);
                                $HSMonth = $HSDate->format('m');
                                $BookingStartingMonth = $value->getStartDate()->format('m');
                                $BookingEndingMonth = $value->getEndDate()->format('m');



                                if ($HSMonth == $BookingStartingMonth) {
                                    $SDBool = true;
                                    $HSID = $highseason->getId(); 
                                }

                                if ($HSMonth == $BookingEndingMonth) {
                                    $EDBool = true;
                                }

                                
                                // add one month onto the high season date
                                $HSDate->add(new DateInterval('P1M'));

                            }                                


                            // if there's no date difference for both months then stop the for loop
                            // if there's a date difference for one month and not the other then stop for loop
                                // and display error message
                             
                            if (($SDBool == true) && ($EDBool == true)) {
                                    
                                    $HSMonths = true;
                                    //$HSID = $highseason->getId();
                                    $startAndEndNot = false;
                                    break;

                            } else if (($SDBool == true) && ($EDBool == false)) {

                                    $this->context->buildViolation("End date outside of start date's high season")
                                    ->atPath('endDate')
                                    ->addViolation();
                                    $startAndEndNot = false;
                                    break;

                            } else if (($SDBool == false) && ($EDBool == true)) {

                                    $this->context->buildViolation("Start date outside of end date's high season")
                                    ->atPath('startDate')
                                    ->addViolation();
                                    $startAndEndNot = false;
                                    break;

                            } else {
                                    $startAndEndNot = true;
                            }
                    }
        
                           
        
                if (($HSMonths == true) && ($startAndEndNot == false)) {
            
                            
                    
                   // $contact = $value->getContact();
                    //$contactID = $contact->getId();                                
               
                    
                     // This is where the error lies
                      $HS = $this->doctrine->getRepository('AppBundle:HighSeason')->getHighSeasonByID($HSID);
                    $OCPBs = $this->doctrine->getRepository('AppBundle:Period')->getOCPBs($value->getContact()->getId());
                    $PBs = $this->doctrine->getRepository('AppBundle:Period')->getPBsForContact($value->getContact()->getId());
                    
                    
                    
                    // Do not increment contactPBCount if the existing period booking is the booking being edited - changed
                    
                    // check if there's a contact PB within the high season month
                       
                    // check if contact PB's start date and end date month match month in highseason
                    
                    
                    $contactPBCount = 0;
                    $otherContactPBCount = 1;
                    $PBStartingMonthBool = false;
                    $PBEndingMonthBool = false;
                    $PBYear = false;
                    
                    
                    foreach ($PBs as $PB){
                    
                            $HSDate = clone $HS->getStartDate();
                                  
                            $diff=date_diff($HS->getStartDate(),$HS->getEndDate());

                            $months = $diff->format('%m');   
                            
                            
                             // loop through the date difference
                            for ($i = 0; $i <= $months; $i++)
                            {
                                                                
                                $HSMonth = $HSDate->format('m');
                                $PBStartingMonth = $PB->getStartDate()->format('m');
                                $PBEndingMonth = $PB->getEndDate()->format('m');
                                                 

                                // if high season month = contact PB month
                                if ($HSMonth == $PBStartingMonth) {
                                    
                                    $PBStartingMonthBool = true;
                                    
                                }
                                
                                if ($HSMonth == $PBEndingMonth) {
                                    
                                    $PBEndingMonthBool = true;
                                                                   
                                }
                                
                                if ($PB->getStartDate()->format('y') == $value->getStartDate()->format('y'))
                                {
                                    $PBYear = true;
                                }

                                if ((($PBStartingMonthBool == true) && ($PBEndingMonthBool == true)) && ($PBYear == true)) {
                                    // pbedit registered in the count
                                    $contactPBCount = 1;
                                    $contactPBID = $PB->getId();
                                    break;
                                }
                                // add one month onto the high season date
                                $HSDate->add(new DateInterval('P1M'));

                            }   
                    
                    }
                   
                    $otherContactPBCount = 0;
                                        
                    
                    // check if there's an OCPB in the high season month
                    // get OCPB in high season
                    // loop through all OCPBs and check if start date matches a month in the NPB high season
                    // If there's a match then increment otherContactPBCount
                    foreach ($OCPBs as $OCPB) {                                                 
                        
                            $HSDateOCPB = clone $HS->getStartDate();
                            $diff=date_diff($HS->getStartDate(),$HS->getEndDate());

                            $months = (int)$diff->format('%m');   
                            
                             // loop through the date difference
                            for ($i = 0; $i <= $months; $i++)
                            {

                                $HSMonth = $HSDateOCPB->format('m');
                                $OCPBStartingMonth = $OCPB->getStartDate()->format('m');
                                
                                
                                if (($HSMonth == $OCPBStartingMonth) && ($OCPB->getStartDate()->format('y') == $value->getStartDate()->format('y'))) {
                                    $otherContactPBCount = 1;
                                    $otherContactPBID = $OCPB->getId();
                                }
                                
                                

                                // add one month onto the high season date
                                $HSDateOCPB->add(new DateInterval('P1M'));

                            } 
                    
                    }
                                        
                   
                            
 
                    // three branch if statement                    

                    // first branch

                    // In NPB year...
                    
                    // If period booking exists for period booking contact and no period booking for other contact    
               

                    if (($contactPBCount > 0) && ($otherContactPBCount < 1)) {
                        
                        //$contactPBID = $this->doctrine->getRepository('AppBundle:Period')->getContactPBID($contactID);
                                           
                        
                        // IF NPB matches existing PB 
                        $matchCount = $this->doctrine->getRepository('AppBundle:Period')->getMatchCount($value->getStartDate(), $value->getEndDate());
                        $matchCountByID = $this->doctrine->getRepository('AppBundle:Period')->getMatchCountByID($value->getId(), $value->getStartDate(), $value->getEndDate());                                                   
                            
                        
                        if ($matchCount == 1) {
                         
                            $this->context->buildViolation("New period booking matches existing period booking.")
                            ->atPath('startDate')
                            ->addViolation();


                            $this->context->buildViolation("New period booking matches existing period booking.")
                            ->atPath('endDate')
                            ->addViolation();
                            
                        } else {
                            if ($value->getId() == null) {
                                // set existing period booking to draft
                                $this->doctrine->getRepository('AppBundle:Period')->setPBToDraft($contactPBID);
                            }
                                // otherwise just move the booking and do not set to draft
                        }
                    } // if period booking doesn't exist for NPB contact and period booking exists for other contact
                    else if (($contactPBCount < 1) && ($otherContactPBCount > 0))
                    {
                                      
                       
                        
                        
                        // If NPB adjacent to OCPB
                        // If NPB start date = OCPB end date + 1 day
                        // OR If NPB end date = OCPB start date - 1 day
                        
                        // get OCPB
                        
                        // If next to OCPB, it will fit, because there are no other PBs for that contact and it has already been checked to
                            // see if the NPB is in the high season earlier in the validation
                        $OCPB = $this->doctrine->getRepository('AppBundle:Period')->getOCPBById($otherContactPBID);
                       
                        // The booking doesn't change until after validation - value is a copy of the existing booking
                        //  
                        // 
                        // if NPB or (draft to NPB and contact not changed) then check if adjacent
                        if (($value->getId() == null) || (($OCPB->getId() == $value->getId()) 
                                && ( ($OCPB->getDraft() == true) && ($OCPB->getContact()->getId() == $value->getContact()->getId()) ))){
                            
                            If (($value->getEndDate() != $OCPB->getStartDate()->sub(new DateInterval('P1D')))
                                && ($value->getStartDate() != $OCPB->getEndDate()->add(new DateInterval('P1D'))))
                            {
                                 $this->context->buildViolation("New period booking not next to other contact's period booking.")
                                ->atPath('startDate')
                                ->addViolation();


                                $this->context->buildViolation("New period booking not next to other contact's period booking.")
                                ->atPath('endDate')
                                ->addViolation();
                            }
                            
                        }
                        
                        // else if it is an existing booking and a contact change or it is an existing booking draft to NPB change and a contact change
                        // change booking contact with or without new dates - booking changing, not inserting next to other OCPB
                        
                        
                    } // if a period booking exists for both contacts
                    else if (($contactPBCount > 0) && ($otherContactPBCount > 0)) {
                           
                       
                        
                         $OCPB1 = $this->doctrine->getRepository('AppBundle:Period')->getOCPBByID($otherContactPBID);
                        
                        // change sides of period booking                                                
                                                
                        // if NPB = existing period booking or NPB not next to other side of OCPB
                        
                        $matchCount = 0;
                        
                        // match existing PB with dates
                        $matchCount = $this->doctrine->getRepository('AppBundle:Period')->getMatchCount($value->getStartDate(), $value->getEndDate());
                        // match existing PB with ID and dates
                        $matchCountByID = $this->doctrine->getRepository('AppBundle:Period')->getMatchCountByID($value->getId(), $value->getStartDate(), $value->getEndDate());
                        
                       
                        // get start or end date next to other side of OCPB
                        // ------------------------------------------------
                        // get the start date of OCPB
                        // subdate = sub 1 day off of start date
                        // if subdate matches an end date for an existing PB (not including edited PB)
                        // (It doesn't include the edited PB in the end date match, so rtnDate = subdate)
                            // get first slot other side of OCPB
                            // rtnDate = add 1 day on to end date of OCPB
                            // NPB start date boolean = true
                        // else 
                            // rtnDate = date
                            // NPB end date boolean = true!
                        
                        // check if start or end date equals equivalent start or end date of NPB   
                        // ---------------------------------------------------------------------                        
                        // if NPBstartDateBool = true 
                            // if rtnDate == NPB start date                                                    
                                // rtnDateBool = true
                            
                        // else if NPBendDateBool = true
                            // if rtnDate == NPB end date
                                // rtnDateBool = true
                                                                           
                        
                            $OCPBStartDate = $OCPB1->getStartDate();
                            $OCPBEndDate = $OCPB1->getEndDate();
                            $OCPBSubDate = $OCPBStartDate->sub(new DateInterval('P1D'));
                            $OCPBAddDate = $OCPBEndDate->add(new DateInterval('P1D'));
                            $PBsBoth = $this->doctrine->getRepository('AppBundle:Period')->getPBsForContact($value->getContact()->getId());
                            //$PBforContact = $this->doctrine->getRepository('AppBundle:Period')->getPBForContact(6);
                            $rtnDateBool = false;
                            $rtnDatesAvaBool = false;
                            $NPBSDBool = false;
                            $NPBEDBool = false;
                            
                            

                            // loop through period bookings                            
                            
                            foreach ($PBsBoth as $PBB) {
                                
                               
                                
                                if (($OCPBSubDate == $PBB->getEndDate()) && ( $value->getId() == null)) {
                                    // available start date(other side)
                                    $rtnDate = $OCPBAddDate;
                                    $NPBSDBool = true;
                                    
                                }
                                
                                if ((($OCPBSubDate == $PBB->getEndDate()) || ($OCPBAddDate == $PBB->getStartDate())) 
                                        && ($PBB->getId() == $value->getId())) {                                   
                                    // available start and end date
                                    $rtnDatesAvaBool = true;
                                    $rtnStartDate = $OCPBAddDate;
                                    $rtnEndDate = $OCPBSubDate;
                                    $PBEditSD = clone $PBB->getStartDate();
                                                    
                                    if ($PBEditSD == $value->getStartDate())
                                    {                 
                                       
                                        $rtnEditSame = true;
                                        
                                        
                                        
                                    } else {
                                        
                                        
                                        $rtnEditSame = false;
                                    }  
                                    
                                } 
                                
                                if (($OCPBAddDate == $PBB->getStartDate()) && ( $value->getId() == null)){
                                    // available end date(other side)
                                    $rtnDate = $OCPBSubDate;
                                    $NPBEDBool = true;
                                }
                            }

                            
                            
                            // rtnDate = one date that is either available start or end date
                            // check if start or end date available equals equivalent start or end date of NPB 
                                                       
                            if ($NPBSDBool == true) {
                                if ($rtnDate == $value->getStartDate()) {
                                    $rtnDateBool = true;
                                }
                            }
                             if ($NPBEDBool == true) {
                                if ($rtnDate == $value->getEndDate()) {
                                    $rtnDateBool = true;
                                }
                            } 
                            
                            if ($rtnDatesAvaBool == true) {
                                
                                
                                
                                if (($rtnStartDate == $value->getStartDate()) || ($rtnEndDate == $value->getEndDate())) {                                    
                                    
                                    $rtnDateBool = true;                                    
 
                                }
                            }
                                                      
                            
                            // if new match or edit match
                            // new match can match any period booking, null will match 1
                            // edit match can match only edit period booking, 1 matches 1
                                // if match is edit match
                                    // error
                            
                            // how can you distinguish between an edit match and 
                            
                            // if (($matchCount == 1) || ($matchCountByID == 1)) {
                            
                            // $matchCountByID unnecessary?
                        if (($matchCount == 1) && ($rtnDateBool == false)) {
                            
                            // rtnDateBool = false here as well
                            
                            $this->context->buildViolation("Entered period booking matches existing period booking.")
                            ->atPath('startDate')
                            ->addViolation();


                            $this->context->buildViolation("Entered period booking matches existing period booking.")
                            ->atPath('endDate')
                            ->addViolation();
                                                                                   
                                                    
                        } else if (($matchCount == 0) && ($rtnDateBool == false)){
                                          
                            if ($rtnEditSame == false) {
                            
                                $this->context->buildViolation("New period booking not next to other contact's period booking.")
                                ->atPath('startDate')
                                ->addViolation();                            

                                $this->context->buildViolation("New period booking not next to other contact's period booking.")
                                ->atPath('endDate')
                                ->addViolation();    
                            
                            } else {
                                
                                // allows an edited booking to use the same dates as it currently has
                                    // for its reinsertion. Overwrites period booking by same contact.
                                
                                $this->doctrine->getRepository('AppBundle:Period')->setPBToDraft($contactPBID);
                            }
                            
                        } else {
                            
                            // if entered period booking is a new period booking and not an existing booking
                            if ($value->getId() == null) { 
                                
                                
                                $this->doctrine->getRepository('AppBundle:Period')->setPBToDraft($contactPBID);
                            }
                        }
                    
                
                    }   
                    
           
            } else if (($HSMonths == false) && ($startAndEndNot == true)){
                $this->context->buildViolation("Start date and end date not in a high season month")
                           ->atPath('startDate')
                           ->addViolation();

                $this->context->buildViolation("Start date and end date not in a high season month")
                           ->atPath('endDate')
                           ->addViolation();
            }
  
        }
      }
      
      
      
    }
    
    
    
    
    }
