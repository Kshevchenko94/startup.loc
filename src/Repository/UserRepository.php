<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\ORMException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, User::class);
        $this->security = $security;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * @param UserInterface $user
     * @param string $newEncodedPassword
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param $value
     * @return array|null
     * @throws DBALException
     */
    public function findOneBySomeField($value): ?array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT u.id,CONCAT_WS(" ",u.last_name,u.first_name) AS full_name FROM `user` u
        WHERE CONCAT_WS(" ",u.last_name,u.first_name) LIKE :value
        OR u.email LIKE :value';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['value' => '%'.$value.'%']);

        return $stmt->fetchAll();
    }


    public function findAuthUser()
    {
        $user = $this->security->getUser();
        return $this->createQueryBuilder('u')
            ->where('u.email = :username')
            ->setParameter('username', $user->getUsername());
    }
}
