<?php

namespace App\Service;

use App\Entity\CarCategory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarCategoryService
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
     * @return CarCategory|null
     */
    public function get(int $id): ?CarCategory
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
    public function getCarCategory(Array $params = array(), int $limit = null, $offset = null): ?array
    {
        return $this->getRepository()->findBy($params, null, $limit, $offset);
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(CarCategory::class);
    }

    /**
     * @param CarCategory $CarCategory
     * @return CarCategory
     * @throws \Error
     */
    public function persist(CarCategory $CarCategory): CarCategory
    {
        try {
            $this->entityManager->persist($CarCategory);
            $this->entityManager->flush();
        } catch (\Error $error) {
            throw new \Error("Bad Request");
        }

        return $CarCategory;
    }

    /**
     * @param CarCategory $CarCategory
     * @return bool
     * @throws \Error
     */
    public function remove(CarCategory $CarCategory): bool
    {
        $this->entityManager->remove($CarCategory);
        $this->entityManager->flush();

        return true;
    }

    public function save(CarCategory $CarCategory): CarCategory
    {
        $this->entityManager->persist($CarCategory);
        $this->entityManager->flush();

        return $CarCategory;
    }
}
