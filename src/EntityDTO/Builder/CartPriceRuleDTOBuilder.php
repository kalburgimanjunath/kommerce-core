<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;

class CartPriceRuleDTOBuilder
{
    use IdDTOBuilderTrait,
        TimeDTOBuilderTrait,
        PromotionStartEndDateDTOBuilderTrait,
        PromotionRedemptionDTOBuilderTrait;

    /** @var CartPriceRule */
    protected $entity;

    /** @var CartPriceRuleDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(CartPriceRule $cartPriceRule, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $cartPriceRule;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->setStartEndDate();
        $this->setRedemption();
        $this->entityDTO->name = $this->entity->getName();
        $this->entityDTO->reducesTaxSubtotal = $this->entity->getReducesTaxSubtotal();
        $this->entityDTO->isRedemptionCountValid = $this->entity->isRedemptionCountValid();
    }

    /**
     * @return CartPriceRuleDTO
     */
    protected function getEntityDTO()
    {
        return new CartPriceRuleDTO;
    }

    public static function setFromDTO(CartPriceRule & $cartPriceRule, CartPriceRuleDTO $cartPriceRuleDTO)
    {
        $cartPriceRule->setName($cartPriceRuleDTO->name);
        $cartPriceRule->setMaxRedemptions($cartPriceRuleDTO->maxRedemptions);
        $cartPriceRule->setReducesTaxSubtotal($cartPriceRuleDTO->reducesTaxSubtotal);
        $cartPriceRule->setStart($cartPriceRuleDTO->start);
        $cartPriceRule->setEnd($cartPriceRuleDTO->end);
    }

    /**
     * @return static
     */
    public function withCartPriceRuleItems()
    {
        foreach ($this->entity->getCartPriceRuleItems() as $cartPriceRuleItem) {
            $this->entityDTO->cartPriceRuleItems[] = $this->dtoBuilderFactory
                ->getCartPriceRuleItemDTOBuilder($cartPriceRuleItem)
                ->withAllData()
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withCartPriceRuleDiscounts()
    {
        foreach ($this->entity->getCartPriceRuleDiscounts() as $cartPriceRuleDiscount) {
            $this->entityDTO->cartPriceRuleDiscounts[] = $this->dtoBuilderFactory
                ->getCartPriceRuleDiscountDTOBuilder($cartPriceRuleDiscount)
                ->withAllData()
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData()
    {
        return $this
            ->withCartPriceRuleItems()
            ->withCartPriceRuleDiscounts();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
