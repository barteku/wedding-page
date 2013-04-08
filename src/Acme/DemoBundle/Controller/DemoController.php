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


/**
 * @Route("/", name="homepage")
 * @Template()
 */
class DemoController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $ln = $request->getPreferredLanguage(array('pl','en'));
        
        return $this->redirect($this->generateUrl('homepage_locale', array('_locale' => $ln)), 301);
    }
    
    /**
     * @Route("/{_locale}", name="homepage_locale", defaults={"_locale": "pl"}, requirements={"_locale": "pl|en"})
     * @Template("AcmeDemoBundle:Demo:index.html.twig")
     */
    public function indexLocaleAction()
    {
        return array();
    }
    
    
    /**
     * @Route("/{_locale}/contact", name="contact", defaults={"_locale": "pl"}, requirements={"_locale": "pl|en"})
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }
    
    /**
     * @Route("/{_locale}/registration/complete", name="registration-complete", defaults={"_locale": "pl"}, requirements={"_locale": "pl|en"})
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
                    return $this->redirect($this->generateUrl('registration', array('token' => $token, '_locale' => $_locale)));
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
     * @Route("/{_locale}/place", name="place", defaults={"_locale": "pl"}, requirements={"_locale": "pl|en"})
     * @Template()
     */
    public function placeAction()
    {
        return array();
    }
}
