<?php
/*
 *
 * Copyright 2012 Human Resource Information System
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 * @since 2012
 * @author John Francis Mukulu <john.f.mukulu@gmail.com>
 *
 */
namespace Hris\RecordsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Hris\OrganisationunitBundle\Entity\Organisationunit;
use Hris\FormBundle\Entity\Form;

/**
 * Hris\RecordsBundle\Entity\Record
 *
 * @ORM\Table(name="hris_record")
 * @ORM\Entity(repositoryClass="Hris\RecordsBundle\Entity\RecordRepository")
 */
class Record
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string $uid
     *
     * @ORM\Column(name="uid", type="string", length=13, unique=true)
     */
    private $uid;

    /**
     * @var string $instance
     *
     * @ORM\Column(name="instance", type="string", length=64, unique=true)
     */
    private $instance;
    
    /**
     * @var Hris\OrganisationunitBundle\Entity\Organisationunit $organisationunit
     *
     * @ORM\ManyToOne(targetEntity="Hris\OrganisationunitBundle\Entity\Organisationunit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organisationunit_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     * })
     */
    private $organisationunit;
    
    /**
     * @var Hris\FormBundle\Entity\Form $form
     *
     * @ORM\ManyToOne(targetEntity="Hris\FormBundle\Entity\Form",inversedBy="record")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="form_id", referencedColumnName="id",nullable=false, onDelete="CASCADE")
     * })
     */
    private $form;

    /**
     * @var boolean $complete
     *
     * @ORM\Column(name="complete", type="boolean")
     */
    private $complete;
    
    /**
     * @var boolean $correct
     *
     * @ORM\Column(name="correct", type="boolean")
     */
    private $correct;

    /**
     * @var boolean $hashistory
     *
     * @ORM\Column(name="hashistory", type="boolean")
     */
    private $hashistory;

    /**
     * @var boolean $hastraining
     *
     * @ORM\Column(name="hastraining", type="boolean")
     */
    private $hastraining;

    /**
     * @var \DateTime $datecreated
     *
     * @ORM\Column(name="datecreated", type="datetime")
     */
    private $datecreated;

    /**
     * @var \DateTime $lastupdated
     *
     * @ORM\Column(name="lastupdated", type="datetime", nullable=true)
     */
    private $lastupdated;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=64, unique=true)
     */
    private $username;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->complete = FALSE;
    	$this->hashistory = FALSE;
    	$this->hastraining = FALSE;
    	$this->correct = FALSE;
    	$this->uid = uniqid();
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
     * Set instance
     *
     * @param string $instance
     * @return Record
     */
    public function setInstance($instance)
    {
        $this->instance = $instance;
    
        return $this;
    }

    /**
     * Get instance
     *
     * @return string 
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Set datecreated
     *
     * @param \DateTime $datecreated
     * @return Record
     */
    public function setDatecreated($datecreated)
    {
        $this->datecreated = $datecreated;
    
        return $this;
    }

    /**
     * Get datecreated
     *
     * @return \DateTime 
     */
    public function getDatecreated()
    {
        return $this->datecreated;
    }

    /**
     * Set lastupdated
     *
     * @param \DateTime $lastupdated
     * @return Record
     */
    public function setLastupdated($lastupdated)
    {
        $this->lastupdated = $lastupdated;
    
        return $this;
    }

    /**
     * Get lastupdated
     *
     * @return \DateTime 
     */
    public function getLastupdated()
    {
        return $this->lastupdated;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Record
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set complete
     *
     * @param boolean $complete
     * @return Record
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
    
        return $this;
    }

    /**
     * Get complete
     *
     * @return boolean 
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set hashistory
     *
     * @param boolean $hashistory
     * @return Record
     */
    public function setHashistory($hashistory)
    {
        $this->hashistory = $hashistory;
    
        return $this;
    }

    /**
     * Get hashistory
     *
     * @return boolean 
     */
    public function getHashistory()
    {
        return $this->hashistory;
    }

    /**
     * Set hastraining
     *
     * @param boolean $hastraining
     * @return Record
     */
    public function setHastraining($hastraining)
    {
        $this->hastraining = $hastraining;
    
        return $this;
    }

    /**
     * Get hastraining
     *
     * @return boolean 
     */
    public function getHastraining()
    {
        return $this->hastraining;
    }

    /**
     * Set correct
     *
     * @param boolean $correct
     * @return Record
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
    
        return $this;
    }

    /**
     * Get correct
     *
     * @return boolean 
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Set uid
     *
     * @param string $uid
     * @return Record
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    
        return $this;
    }

    /**
     * Get uid
     *
     * @return string 
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set organisationunit
     *
     * @param \Hris\OrganisationunitBundle\Entity\Organisationunit $organisationunit
     * @return Record
     */
    public function setOrganisationunit(\Hris\OrganisationunitBundle\Entity\Organisationunit $organisationunit = null)
    {
        $this->organisationunit = $organisationunit;
    
        return $this;
    }

    /**
     * Get organisationunit
     *
     * @return \Hris\OrganisationunitBundle\Entity\Organisationunit
     */
    public function getOrganisationunit()
    {
        return $this->organisationunit;
    }

    /**
     * Set form
     *
     * @param \Hris\FormBundle\Entity\Form $form
     * @return Record
     */
    public function setForm(\Hris\FormBundle\Entity\Form $form)
    {
        $this->form = $form;
    
        return $this;
    }

    /**
     * Get form
     *
     * @return Hris\FormBundle\Entity\Form 
     */
    public function getForm()
    {
        return $this->form;
    }
}