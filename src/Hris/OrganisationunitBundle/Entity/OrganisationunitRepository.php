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
namespace Hris\OrganisationunitBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * OrganisationunitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrganisationunitRepository extends EntityRepository
{
    /**
     * Returns organisationunit count
     * @param Organisationunit $organisationunit
     * @return null|integer
     */
    public function getImmediateChildrenCount( Organisationunit $organisationunit)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder->select('COUNT(organisationunit')
                            ->from('HrisOrganisationunitBundle:Organisationunit','organisationunit')
                            ->where('organisationunit.parent = :parent')
                            ->setParameters(array(
                                        'parent'=>$organisationunit
                            )
            )->getQuery();

        try {
            $immediateChildren = $query->getSingleResult();
            $result = $immediateChildren[1];
        } catch( NoResultException $e) {
            $result = NULL;
        }
        return $result;
    }

    /**
     * Returns immediate organisationunits
     * @param Organisationunit $organisationunit
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImmediateChildren( Organisationunit $organisationunit, $active=NULL)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $query = $queryBuilder->select('organisationunit')
            ->from('HrisOrganisationunitBundle:Organisationunit','organisationunit')
            ->where('organisationunit.parent = :parent');
        if($active==True) $query = $query->andWhere('organisationunit.active=True');
        $query = $query->setParameters(array(
                    'parent'=>$organisationunit
                )
            )->getQuery();

        try {
            $immediateChildren = $query->getResult();
            if(!empty($immediateChildren)) {
                $result = $immediateChildren[1];
            }else {
                $result=NULL;
            }
        } catch( NoResultException $e) {
            $result = NULL;
        }
        return $result;
    }

    /**
     * Returns organisationunit children collection
     * @param Organisationunit $organisationunit
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAllChildren( Organisationunit $organisationunit)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $organisationunitChildren = $queryBuilder->select('organisationunit', 'p.shortname')
            ->from('HrisOrganisationunitBundle:Organisationunit','organisationunit')
            ->join('organisationunit.parent','p')
            ->join('organisationunit.organisationunitStructure','organisationunitStructure')
            ->join('organisationunitStructure.level','level')
            ->andWhere('
                        (
                            level.level >= :organisationunitLevel
                            AND organisationunitStructure.level'.$organisationunit->getOrganisationunitStructure()->getLevel()->getLevel().'Organisationunit=:levelOrganisationunit
                        )'
            )
            ->setParameters(array(
                'levelOrganisationunit'=>$organisationunit,
                'organisationunitLevel'=>$organisationunit->getOrganisationunitStructure()->getLevel()->getLevel()
            ))
            ->getQuery()->getArrayResult();

        return $organisationunitChildren;
    }

    /**
     * Get all values from specific key in a multidimensional array
     *
     * @param $key string
     * @param $arr array
     * @return null|string|array
     */
    public function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){if($k == $key) array_push($val, $v);});
        return count($val) > 1 ? $val : array_pop($val);
    }
}
