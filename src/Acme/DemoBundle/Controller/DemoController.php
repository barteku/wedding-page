<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\DemoBundle\Entity\Guest;
use Acme\DemoBundle\Form\Type\GuestType;

class DemoController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    
    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                // .. setup a message and send it
                // http://symfony.com/doc/current/cookbook/email.html

                $this->get('session')->setFlash('notice', 'Message sent!');

                return new RedirectResponse($this->generateUrl('_demo'));
            }
        }

        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/registration/complete", name="registration-complete")
     * @Template()
     */
    public function registrationCompleteAction()
    {
        return array();
    }
    
    /**
     * @Route("/registration/{token}", name="registration", defaults={"token" : ""})
     * @Template()
     */
    public function registrationAction($token)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $guest = $em->getRepository('AcmeDemoBundle:Guest')->findOneBy(array('token'=>$token));
        
        if(!($guest instanceof Guest)){
            $guest = new Guest();
        }
        
        $form = $this->createForm(new GuestType(), $guest);
        
        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if($form->isValid()){
                if($form->has('token')){
                    return $this->redirect($this->generateUrl('registration', array('token' => $form->get('token'))));
                }elseif($form->has('confirmed')){
                    $em->persist($guest);
                    $em->flush();

                    return $this->redirect($this->generateUrl('registration-complete'));
                }
            }
        }
        
        return array(
            'form' => $form->createView(),
            'guest' => $guest
        );
    }
    
    
    /**
     * @Route("/place", name="place")
     * @Template()
     */
    public function placeAction()
    {
        return array();
    }
}
