<?php
namespace inklabs\kommerce\ActionHandler\CatalogPromotion;

use inklabs\kommerce\Action\CatalogPromotion\GetCatalogPromotionQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetCatalogPromotionHandler implements QueryHandlerInterface
{
    /** @var GetCatalogPromotionQuery */
    private $query;

    /** @var CatalogPromotionRepositoryInterface */
    private $catalogPromotionRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetCatalogPromotionQuery $query,
        CatalogPromotionRepositoryInterface $catalogPromotionRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->catalogPromotionRepository = $catalogPromotionRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $catalogPromotion = $this->catalogPromotionRepository->findOneById(
            $this->query->getRequest()->getCatalogPromotionId()
        );

        $this->query->getResponse()->setCatalogPromotionDTOBuilder(
            $this->dtoBuilderFactory->getCatalogPromotionDTOBuilder($catalogPromotion)
        );
    }
}
