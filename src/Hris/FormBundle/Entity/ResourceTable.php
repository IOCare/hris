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
namespace Hris\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Hris\FormBundle\Entity\ResourceTableFieldMember;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hris\FormBundle\Entity\ResourceTable
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="hris_resourcetable")
 * @ORM\Entity(repositoryClass="Hris\FormBundle\Entity\ResourceTableRepository")
 */
class ResourceTable
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
     * @Gedmo\Versioned
     * @ORM\Column(name="uid", type="string", length=13, unique=true)
     */
    private $uid;

    /**
     * @var string $name
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=64, unique=true)
     */
    private $name;

    /**
     * @var string $description
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var ResourceTableFieldMember $resourceTableFieldMember
     *
     * @ORM\OneToMany(targetEntity="Hris\FormBundle\Entity\ResourceTableFieldMember", mappedBy="resourceTable",cascade={"ALL"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $resourceTableFieldMember;

    /**
     * @var \DateTime $datecreated
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="datecreated", type="datetime")
     */
    private $datecreated;

    /**
     * @var \DateTime $lastupdated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="lastupdated", type="datetime", nullable=true)
     */
    private $lastupdated;


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
     * @return ResourceTable
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
     * Set datecreated
     *
     * @param \DateTime $datecreated
     * @return ResourceTable
     */
    public function setDatecreated($datecreated)
    {
        $this->datecreated = $datecreated;
    
        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Field
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
     * @return ResourceTable
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
     * Set uid
     *
     * @param string $uid
     * @return ResourceTable
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
     * Add resourceTableFieldMember
     *
     * @param ResourceTableFieldMember $resourceTableFieldMember
     * @return ResourceTable
     */
    public function addResourceTableFieldMember(ResourceTableFieldMember $resourceTableFieldMember)
    {
        $this->resourceTableFieldMember[] = $resourceTableFieldMember;
    
        return $this;
    }

    /**
     * Remove resourceTableFieldMember
     *
     * @param ResourceTableFieldMember $resourceTableFieldMember
     */
    public function removeResourceTableFieldMember(ResourceTableFieldMember $resourceTableFieldMember)
    {
        $this->resourceTableFieldMember->removeElement($resourceTableFieldMember);
    }

    /**
     * Get resourceTableFieldMember
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResourceTableFieldMember()
    {
        return $this->resourceTableFieldMember;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resourceTableFieldMember = new ArrayCollection();
        $this->uid = uniqid();
    }

    /**
     * Get Entity verbose name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
    
}