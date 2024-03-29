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
use Symfony\Component\HttpFoundation\Request;


class DemoController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $ln = $request->getPreferredLanguage(array('pl','en'));
        if($ln != 'pl' && $ln != "en"){
          $ln = 'pl';
        }
        
        return new RedirectResponse($this->generateUrl('homepage_locale', array('_locale' => $ln)));
    }
        
    /**
     * @Route("/{_locale}", name="homepage_locale", requirements={"_locale": "pl|en"})
     * @Template("AcmeDemoBundle:Demo:index.html.twig")
     */
    public function indexLocaleAction()
    {
        return array();
    }
    
    
    /**
     * @Route("/{_locale}/contact", name="contact", requirements={"_locale": "pl|en"})
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }
    
    /**
     * @Route("/{_locale}/registration/complete", name="registration-complete", requirements={"_locale": "pl|en"})
     * @Template()
     */
    public function registrationCompleteAction()
    {
        return array();
    }
    
    /**
     * @Route("/{_locale}/registration/{token}", name="registration", defaults={"token" : "", "_locale": "pl"}, requirements={"_locale": "pl|en"})
     * @Template()
     */
    public function registrationAction($token, $_locale)
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
                    return $this->redirect($this->generateUrl('registration', array('token' => $guest->getToken(), '_locale' => $_locale)));
                }elseif($form->has('confirmed')){
                    $em->persist($guest);
                    $em->flush();

                    return $this->redirect($this->generateUrl('registration-complete', array('_locale' => $_locale)));
                }
            }
        }
        
        return array(
            'form' => $form->createView(),
            'guest' => $guest
        );
    }
    
    
    /**
     * @Route("/{_locale}/place", name="place", requirements={"_locale": "pl|en"})
     * @Template()
     */
    public function placeAction()
    {
        return array();
    }
    
    
    /**
     * @Route("/{_locale}/gifts", name="gifts", defaults={"_locale": "pl"}, requirements={"_locale": "pl|en"})
     * @Template()
     */
    public function giftsAction()
    {
        return array();
    }
}
