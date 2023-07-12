<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use Doctrine\ORM\EntityManagerInterface;

trait DatabaseTransactionTrait
{
    protected function beingTransaction(): void
    {
        $manager =  $this->getEntityManager();

        $manager->beginTransaction();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get('doctrine')->getManager();

        return $entityManager;
    }
    /**
     * @template T
     * @param class-string<T> $entityName
     * @return array<int, T>
     */
    protected function getEntities(string $entityName): array
    {
        return $this->getEntityManager()->getUnitOfWork()->getEntityPersister($entityName)->loadAll();
    }

    protected function rollbackTransaction(): void
    {
        $this->getEntityManager()->rollback();
        $this->getEntityManager()->close();
    }
}
