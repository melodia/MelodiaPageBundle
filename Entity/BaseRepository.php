<?php

/*
 * This file is part of the Melodia Page Bundle
 *
 * (c) Alexey Ryzhkov <alioch@yandex.ru>
 */

namespace Melodia\PageBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
    /**
     * @param integer $page
     * @param integer $limit
     * @param array $order Sorting options
     *  Format of the $order argument:
     *      $order = array(
     *          array(
     *              'property' = > 'createdAt',
     *              'direction' => 'ASC',
     *          ),
     *      )
     * @param string $where
     * @return array
     */
    public function findSubset($page, $limit, $order = array(), $where = '')
    {
        $qb = $this->createQueryBuilder('entity');

        if ($where) {
            $qb->where('entity.' . $where);
        }

        foreach ($order as $set) {
            if (isset($set['property']) && isset($set['direction'])) {
                $qb->orderBy('entity.' . $set['property'], $set['direction']);
            }
        }

        if ($page && $limit) {
            $qb->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}