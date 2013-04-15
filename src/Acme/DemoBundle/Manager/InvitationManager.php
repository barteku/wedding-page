<?php

namespace Acme\DemoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Acme\DemoBundle\Entity\Guest;


/**
 * Description of InvitationManager
 *
 * @author bart
 */
class InvitationManager {
    /**
     * 
     * @var type object Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     *
     * @var type string
     */
    protected $class;
    
    /**
     *
     * @var type 
     */
    protected $repository;
    
    protected $mailer;
    
    protected $templating;
    
    /**
     * Constructor.
     *
     * @param EntityManager           $em
     * @param string                  $class
     */
    public function __construct(EntityManager $em, $class, $mailer, $templating)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     * Returns an empty BaseORMManager instance
     *
     * @return object  $class
     */
    public function create()
    {
        $class = $this->getClass();
        $object = new $class;
        
        return $object;
    }
    
    
    public function persist($object, $andFlush = true)
    {
        $this->em->persist($object);
        if ($andFlush) {
            $this->em->flush();
        }
    }
    
    
    public function findById($id){
        return $this->findOneBy(array('id' => $id));
    }
    

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    
    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }
    
    
    
    public function sendInvitation(Guest $guest){
        if($guest->getEmail() != ''){
            $title = 'Zaproszenie dla '.$guest->getFullName();
            if($guest->getLocale() == 'en'){
                $title = 'Invitation for '.$guest->getFullName();
            }
            
            $message = \Swift_Message::newInstance()
                    ->setSubject($title)
                    ->setFrom(array('urbanski.bartek@gmail.com' => 'Joasia i Bartek'))
                    ->setTo($guest->getEmail())
                    ->setBody($this->templating->render('AcmeDemoBundle:Mailer:invitation.html.twig', array('guest' => $guest)))
                    ->setBcc('urbanski.bartek@gmail.com')
                    ->setContentType("text/html")
                    ;
            //return $this->mailer->send($message);
        }
    }
    
    
    public function sendToAll(){
        $counter = 0;
        
        foreach($this->repository->findAll() as $guest){
            if($guest->getId()>56){
                if($this->sendInvitation($guest)){
                    $counter ++;
                    echo $guest->getEmail()."\n";
                }
            }
        }
        
        return $counter;
    }
    
    
}