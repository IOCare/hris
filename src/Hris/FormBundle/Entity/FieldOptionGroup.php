<?php
/*
 *
 * Copyright 2012John Francis Mukulu <john.f.mukulu@gmail.com>
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
 *
 */
namespace Hris\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Hris\FormBundle\Entity\FriendlyReportCategory;
use Hris\FormBundle\Entity\FieldOptionGroupset;
use Hris\FormBundle\Entity\FieldOption;
use Hris\FormBundle\Entity\Field;

/**
 * Hris\FormBundle\Entity\FieldOptionGroup
 *
 * @ORM\Table(name="hris_fieldoptiongroup")
 * @ORM\Entity(repositoryClass="Hris\FormBundle\Entity\FieldOptionGroupRepository")
 */
class FieldOptionGroup
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string $uid
     *
     * @ORM\Column(name="uid", type="string", length=13)
     */
    private $uid;
    
    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var \DateTime $datecreated
     *
     * @ORM\Column(name="datecreated", type="datetime")
     */
    private $datecreated;
    
    /**
     * @var \DateTime $lastmodified
     *
     * @ORM\Column(name="lastmodified", type="datetime")
     */
    private $lastmodified;
    
    /**
     * @var Hris\FormBundle\Entity\FieldOption $fieldOption
     *
     * @ORM\ManyToMany(targetEntity="Hris\FormBundle\Entity\FieldOption", inversedBy="fieldOptionGroup")
     * @ORM\JoinTable(name="hris_fieldoptiongroup_members",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fieldoptiongroup_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fieldoption_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    
    private $fieldOption;
    
    /**
     * @var Hris\FormBundle\Entity\Field $field
     *
     * @ORM\ManyToOne(targetEntity="Hris\FormBundle\Entity\Field")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="field_id", referencedColumnName="id")
     * })
     */
    private $field;
    
    /**
     * @var Hris\FormBundle\Entity\FieldOptionGroupset $fieldOptionGroupset
     *
     * @ORM\ManyToMany(targetEntity="Hris\FormBundle\Entity\FieldOptionGroupset", mappedBy="fieldOptionGroup")
     */
    private $fieldOptionGroupset;
    
    /**
     * @var Hris\FormBundle\Entity\FriendlyReportCategory $friendlyReportCategory
     *
     * @ORM\OneToMany(targetEntity="Hris\FormBundle\Entity\FriendlyReportCategory", mappedBy="fieldOptionGroup")
     */
    private $friendlyReportCategory;


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
     * Set name
     *
     * @param string $name
     * @return FieldOptionGroup
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set uid
     *
     * @param string $uid
     * @return FieldOptionGroup
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
     * Constructor
     */
    public function __construct()
    {
        $this->fieldOption = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set description
     *
     * @param string $description
     * @return FieldOptionGroup
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datecreated
     *
     * @param \DateTime $datecreated
     * @return FieldOptionGroup
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
     * Set lastmodified
     *
     * @param \DateTime $lastmodified
     * @return FieldOptionGroup
     */
    public function setLastmodified($lastmodified)
    {
        $this->lastmodified = $lastmodified;
    
        return $this;
    }

    /**
     * Get lastmodified
     *
     * @return \DateTime 
     */
    public function getLastmodified()
    {
        return $this->lastmodified;
    }

    /**
     * Add fieldOption
     *
     * @param Hris\FormBundle\Entity\FieldOption $fieldOption
     * @return FieldOptionGroup
     */
    public function addFieldOption(\Hris\FormBundle\Entity\FieldOption $fieldOption)
    {
        $this->fieldOption[] = $fieldOption;
    
        return $this;
    }

    /**
     * Remove fieldOption
     *
     * @param Hris\FormBundle\Entity\FieldOption $fieldOption
     */
    public function removeFieldOption(\Hris\FormBundle\Entity\FieldOption $fieldOption)
    {
        $this->fieldOption->removeElement($fieldOption);
    }

    /**
     * Get fieldOption
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFieldOption()
    {
        return $this->fieldOption;
    }

    /**
     * Set field
     *
     * @param Hris\FormBundle\Entity\Field $field
     * @return FieldOptionGroup
     */
    public function setField(\Hris\FormBundle\Entity\Field $field = null)
    {
        $this->field = $field;
    
        return $this;
    }

    /**
     * Get field
     *
     * @return Hris\FormBundle\Entity\Field 
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Add fieldOptionGroupset
     *
     * @param Hris\FormBundle\Entity\FieldOptionGroupset $fieldOptionGroupset
     * @return FieldOptionGroup
     */
    public function addFieldOptionGroupset(\Hris\FormBundle\Entity\FieldOptionGroupset $fieldOptionGroupset)
    {
        $this->fieldOptionGroupset[] = $fieldOptionGroupset;
    
        return $this;
    }

    /**
     * Remove fieldOptionGroupset
     *
     * @param Hris\FormBundle\Entity\FieldOptionGroupset $fieldOptionGroupset
     */
    public function removeFieldOptionGroupset(\Hris\FormBundle\Entity\FieldOptionGroupset $fieldOptionGroupset)
    {
        $this->fieldOptionGroupset->removeElement($fieldOptionGroupset);
    }

    /**
     * Get fieldOptionGroupset
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFieldOptionGroupset()
    {
        return $this->fieldOptionGroupset;
    }

    /**
     * Add friendlyReportCategory
     *
     * @param Hris\FormBundle\Entity\FriendlyReportCategory $friendlyReportCategory
     * @return FieldOptionGroup
     */
    public function addFriendlyReportCategory(\Hris\FormBundle\Entity\FriendlyReportCategory $friendlyReportCategory)
    {
        $this->friendlyReportCategory[] = $friendlyReportCategory;
    
        return $this;
    }

    /**
     * Remove friendlyReportCategory
     *
     * @param Hris\FormBundle\Entity\FriendlyReportCategory $friendlyReportCategory
     */
    public function removeFriendlyReportCategory(\Hris\FormBundle\Entity\FriendlyReportCategory $friendlyReportCategory)
    {
        $this->friendlyReportCategory->removeElement($friendlyReportCategory);
    }

    /**
     * Get friendlyReportCategory
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFriendlyReportCategory()
    {
        return $this->friendlyReportCategory;
    }
}