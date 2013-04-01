<?php

namespace Acme\DemoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of GuestRepository
 *
 * @author bartek
 */
class GuestRepository extends EntityRepository {
    
    public function getWithToken($token){
        $q = $this->createQueryBuilder('g')
            ->where('g.token = :token')
        ;
        
        $q->setParameter('token', $token);
        
        return $q->getQuery()->execute();
    }
    
    
}
