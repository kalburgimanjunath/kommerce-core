<?php
namespace inklabs\kommerce\ActionResponse\Product;

use inklabs\kommerce\EntityDTO\Builder\ProductDTOBuilder;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetRandomProductsResponse implements ResponseInterface
{
    /** @var ProductDTO[] */
    protected $productDTOs = [];

    /** @var PricingInterface */
    private $pricing;

    public function __construct(PricingInterface $pricing)
    {
        $this->pricing = $pricing;
    }

    public function addProductDTOBuilder(ProductDTOBuilder $productDTOBuilder): void
    {
        $this->productDTOs[] = $productDTOBuilder
            ->withPrice($this->pricing)
            ->build();
    }

    /**
     * @return ProductDTO[]
     */
    public function getProductDTOs(): array
    {
        return $this->productDTOs;
    }
}
