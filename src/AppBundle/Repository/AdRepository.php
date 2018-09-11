<?php

namespace AppBundle\Repository;

/**
 * AdRepository
 */
class AdRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAdsCostlyPoneys()
    {
        $dql = <<<DQL
SELECT ad_data
FROM AppBundle:Ad ad_data
WHERE ad_data.price >= :price OR ad_data.title LIKE :title
DQL;

        // C'est une autre façon de récupérer mes villes. Plus simple si vous avez des OR comme on peut le voir dans cet exemple
        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter('price', 2000)
            ->setParameter('title', '%oney%')
            ->getResult()
        ;

    }
}
