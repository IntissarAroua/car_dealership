<?php

namespace App\Service;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * AddressesService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @param int $id
     *
     * @return Car|null
     */
    public function get(int $id): ?Car
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param array $params
     * @param int|null $limit
     * @param null $offset
     *
     * @return array|null
     */
    public function getCar(Array $params = array(), int $limit = null, $offset = null): ?array
    {
        return $this->getRepository()->findBy($params, null, $limit, $offset);
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Car::class);
    }

    /**
     * @param Car $Car
     * @return Car
     * @throws \Error
     */
    public function persist(Car $Car): Car
    {
        try {
            $this->entityManager->persist($Car);
            $this->entityManager->flush();
        } catch (\Error $error) {
            throw new \Error("Bad Request");
        }

        return $Car;
    }

    /**
     * @param Car $Car
     * @return bool
     * @throws \Error
     */
    public function remove(Car $Car): bool
    {
        $this->entityManager->remove($Car);
        $this->entityManager->flush();

        return true;
    }

    public function save(Car $Car): Car
    {
        $this->entityManager->persist($Car);
        $this->entityManager->flush();

        return $Car;
    }
}
