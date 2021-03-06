<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CartPriceRuleDiscountDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cartPriceRuleDiscount = $this->dummyData->getCartPriceRuleDiscount();

        $cartPriceRuleDiscountDTO = $this->getDTOBuilderFactory()
            ->getCartPriceRuleDiscountDTOBuilder($cartPriceRuleDiscount)
            ->withAllData()
            ->build();

        $this->assertTrue($cartPriceRuleDiscountDTO instanceof CartPriceRuleDiscountDTO);
        $this->assertTrue($cartPriceRuleDiscountDTO->product instanceof ProductDTO);
    }
}
