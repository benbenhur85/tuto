<?php

namespace OC\PlatformBundle\Entity;
use Doctrine\ORM\EntityRepository;
/**
 * ApplicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApplicationRepository extends \Doctrine\ORM\EntityRepository
{

	public function getApplicationsWithAdvert($limit)
	{
		$qb = $this->createQueryBuilder('a');

		$qb ->join('a.advert', 'adv')
			->addSelect('adv');

		$qb->setMaxResults($limit);
		
		return $qb->getQuery()
				  ->getResult();	
	}	
}
