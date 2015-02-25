<?php

/*
 * This file is part of the Melodia Page Bundle
 *
 * (c) Alexey Ryzhkov <alioch@yandex.ru>
 */

namespace Melodia\PageBundle\Entity;

class PageRepository extends BaseRepository
{
    /**
     * Find only active pages.
     *
     * @param $url
     * @return mixed|null
     */
    public function findByUrl($url)
    {
        if (substr($url, 0, 1) !== '/') {
            $url = '/' . $url;
        }
        $qb = $this->createQueryBuilder('entity')
            ->where('entity.url = :url')
            ->andWhere('entity.isActive = true')
            ->setParameter('url', $url);

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function findByUrlPart($urlPart)
    {
        $qb = $this->createQueryBuilder('entity');
        $qb->where('entity.url LIKE :urlPart')
            ->andWhere('entity.isActive = true')
            ->setParameter('urlPart', '%' . $urlPart . '%');

        return $qb->getQuery()->getResult();
    }

    /**
     * Find only active pages.
     *
     * @param $pageIds
     * @return array
     */
    public function findByPageIds($pageIds)
    {
        if (!is_array($pageIds) || empty($pageIds)) {
            return array();
        }

        return $this->createQueryBuilder('entity')
            ->where('entity.id IN (:pageIds)')
            ->andWhere('entity.isActive = true')
            ->setParameter('pageIds', $pageIds)
            ->getQuery()
            ->getResult();
    }
}
