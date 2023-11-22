<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function add(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    public function getCountOfUsers(): int
    {
        $qb = $this->createQueryBuilder('u');

        // Utilisez la fonction COUNT() pour compter le nombre de produits
        $qb->select('COUNT(u.id)');

        // Exécutez la requête et récupérez le résultat sous forme d'un scalaire (nombre)
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findByKeyword(string $keyword): array
    {
        $qb = $this->createQueryBuilder('user');

        // Utilisation de l'expression LIKE pour rechercher le mot-clé dans les champs 'name' et 'rôles'
        $qb->andWhere($qb->expr()->orX(
            $qb->expr()->like('user.name', ':keyword'),
            $qb->expr()->like('user.roles', ':keyword')
        ))
            ->setParameter('keyword', '%' . $keyword . '%');

        // Exécution de la requête et récupération des résultats
        return $qb->getQuery()->getResult();
    }

    /**
   * @return Users[] Returns an array of Users objects
   * 
   */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
