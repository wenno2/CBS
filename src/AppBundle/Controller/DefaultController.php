<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Contact;
use AppBundle\Entity\FamilyMember;
use AppBundle\Entity\Friend;
use AppBundle\Entity\Booking;
use \Datetime;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
        
        
        
        /*
         *  Creating a contact
         
        
            $contact = new Contact();
            $contact->setFirstName("Francis");
            $contact->setSurname("Huen");
            

            $em = $this->getDoctrine()->getManager();

            $em->persist($contact);
            $em->flush();

            return new Response('Created contact id '.$contact->getId());
         * 
         */

        /*
         *  Creating a family member
         
            $em = $this->getDoctrine()->getManager();
            $member = new FamilyMember();
            $member->setFirstName("Joseph");
            $member->setSurname("White");
            $member->setContact($em->getRepository('AppBundle\Entity\Contact')->findOneBy(array('firstName' => 'Francis', 'surname' => 'Huen')));
            $member->setAddress("11 The Drive, Hillsborough");
            

            $em->persist($member);
            $em->flush();

            return new Response('Created member id '.$member->getId());
         */
        /*
         *  Creating a friend
         
            $em = $this->getDoctrine()->getManager();
            $friend = new Friend();
            $friend->setFirstName("Ben");
            $friend->setSurname("Houghton");            
            $friend->setAddress("leicestershire");
            

            $em->persist($friend);
            $em->flush();

            return new Response('Created friend id '.$friend->getId());        
        */
        /*
         *  Creating a booking
         
        $em = $this->getDoctrine()->getManager();
        $booking = new Booking();
        $booking->setStartDate(new DateTime());
        $booking->setEndDate(new DateTime());
        $booking->setMember($em->getRepository('AppBundle\Entity\FamilyMember')->findOneBy(array('firstName' => 'Joseph', 'surname' => 'White')));
        $booking->addCustomer($em->getRepository('AppBundle\Entity\FamilyMember')->findOneBy(array('firstName' => 'Eleanor', 'surname' => 'White')));
        $booking->addCustomer($em->getRepository('AppBundle\Entity\Friend')->findOneBy(array('firstName' => 'Michael', 'surname' => 'Coull')));
        $booking->addCustomer($em->getRepository('AppBundle\Entity\Friend')->findOneBy(array('firstName' => 'Ben', 'surname' => 'Houghton')));

        $em->persist($booking);
        $em->flush();

        return new Response('Created booking id '.$booking->getId());
         */
        
        /*
         *  Creating a booking without customers
         
        $em = $this->getDoctrine()->getManager();
        $booking = new Booking();
        $booking->setStartDate(new DateTime());
        $booking->setEndDate(new DateTime());
        $booking->setMember($em->getRepository('AppBundle\Entity\FamilyMember')->findOneBy(array('firstName' => 'Joseph', 'surname' => 'White')));
        //$booking->addCustomer($em->getRepository('AppBundle\Entity\FamilyMember')->findOneBy(array('firstName' => 'Joseph', 'surname' => 'White')));

        $em->persist($booking);
        $em->flush();

        return new Response('Created booking id '.$booking->getId());
         * 
         */
    }
}
