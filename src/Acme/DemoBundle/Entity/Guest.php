<?php

namespace Acme\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Acme\DemoBundle\Repository\GuestRepository")
 * @ORM\Table(name="guest")
 */
class Guest {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var type 
     */
    protected $first_name;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @var type 
     */
    protected $last_name;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var type 
     */
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @var type 
     */
    protected $token;
    
    /**
     * @ORM\Column(type="string", length=2)
     * @var type string
     */
    protected $locale;
    
    /**
     * @ORM\Column(type="boolean")
     * @var type boolean
     */
    protected $confirmed = false;
    
    /**
     * @ORM\Column(type="boolean")
     * @var type boolean
     */
    protected $has_partner = false;
    
    /**
     * @ORM\Column(type="integer")
     * @var type integer
     */
    protected $partner = 0;
    
    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;
    
    
    
    public function __toString() {
        return $this->getFullName();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return Guest
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Guest
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Guest
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Guest
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Guest
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return Guest
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set confirmed
     *
     * @param boolean $confirmed
     * @return Guest
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    
        return $this;
    }

    /**
     * Get confirmed
     *
     * @return boolean 
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }
    
    public function getFullName(){
        return $this->getFirstName() . ' ' . $this->getLastName();
    }
            
        

    /**
     * Set has_partner
     *
     * @param boolean $hasPartner
     * @return Guest
     */
    public function setHasPartner($hasPartner)
    {
        $this->has_partner = $hasPartner;
    
        return $this;
    }

    /**
     * Get has_partner
     *
     * @return boolean 
     */
    public function getHasPartner()
    {
        return $this->has_partner;
    }

    /**
     * Set partner
     *
     * @param integer $partner
     * @return Guest
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
    
        return $this;
    }

    /**
     * Get partner
     *
     * @return integer 
     */
    public function getPartner()
    {
        return $this->partner;
    }
}