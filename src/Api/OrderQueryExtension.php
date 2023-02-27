<?php
namespace App\Api;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Order;
use Doctrine\ORM\QueryBuilder;

class OrderQueryExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function applyToCollection(
        QueryBuilder $queryBuilder, 
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass, 
        Operation $operation = null, 
        array $context = []
    ): void
    {
        // if (Order::class === $resourceClass) {
        //     $queryBuilder->andWhere(
        //         sprintf("%s.state = 'published'", $queryBuilder->getRootAliases()[0])
        //     );
        // }
    }

    public function applyToItem(
        QueryBuilder $queryBuilder, 
        QueryNameGeneratorInterface $queryNameGenerator, 
        string $resourceClass, 
        array $identifiers, 
        Operation $operation = null, 
        array $context = []
    ): void
    {
        // if (Order::class === $resourceClass) {
        //     $queryBuilder->andWhere(sprintf("%s.state = 'published'", $queryBuilder->getRootAliases()[0]));
        // }
    }
}