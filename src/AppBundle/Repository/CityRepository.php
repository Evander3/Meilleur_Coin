<?php

namespace AppBundle\Repository;

class CityRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCitiesWithPopulationGreaterThan100000()
    {
        // Si vous voulez créer votre QueryBuilder
        //$this->createQueryBuider()
        //
        //Pour le DQL, vous allez devoir récupérer l'entityManager

        // Maintenant on va faire la même chose mais avec du DQL
        $dql = <<<DQL
SELECT c
FROM AppBundle:City c
WHERE c.population >= :population OR c.name LIKE :name
DQL;

        // C'est une autre façon de récupérer mes villes. Plus simple si vous avez des OR comme on peut le voir dans cet exemple
        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter('population', 100000)
            ->setParameter('name', '%nn%')
            ->getResult()
        ;
    }
}

