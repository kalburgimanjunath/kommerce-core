<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class Product extends AbstractService
{
    /** @var Lib\PricingInterface */
    private $pricing;

    /** @var EntityRepository\ProductInterface */
    private $productRepository;

    /** @var EntityRepository\TagInterface */
    private $tagRepository;

    public function __construct(
        EntityRepository\ProductInterface $productRepository,
        EntityRepository\TagInterface $tagRepository,
        Lib\PricingInterface $pricing
    ) {
        $this->pricing = $pricing;
        $this->productRepository = $productRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @return View\Product|null
     */
    public function find($id)
    {
        $product = $this->productRepository->find($id);

        if ($product === null) {
            return null;
        }

        return $product->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @param Entity\Product $product
     * @return Entity\Product
     */
    public function edit(Entity\Product $product)
    {
        $this->throwValidationErrors($product);
        $this->productRepository->save($product);
        return $product;
    }

    /**
     * @param Entity\Product $product
     * @return Entity\Product
     */
    public function create(Entity\Product $product)
    {
        $this->throwValidationErrors($product);
        $this->productRepository->create($product);
        return $product;
    }

    /**
     * @param int $productId
     * @param string $tagId
     * @throws \LogicException
     */
    public function addTag($productId, $tagId)
    {
        $product = $this->getProductAndThrowExceptionIfMissing($productId);
        $tag = $this->getTagAndThrowExceptionIfMissing($tagId);

        $product->addTag($tag);

        $this->productRepository->save($product);
    }

    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository
            ->getAllProducts($queryString, $pagination);

        return $this->getViewProducts($products);
    }

    /**
     * @param View\Product|View\Product[] $products
     * @param int $limit
     * @return View\Product[]
     */
    public function getRelatedProducts($products, $limit = 12)
    {
        if (! is_array($products)) {
            $products = [$products];
        }

        $productIds = [];
        $tagIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->id;
            foreach ($product->tags as $tag) {
                $tagIds[] = $tag->id;
            }
        }

        $products = $this->productRepository->getRelatedProductsByIds($productIds, $tagIds, $limit);

        return $this->getViewProductsWithPrice($products);
    }

    public function getProductsByTag(View\Tag $tag, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository->getProductsByTagId($tag->id, $pagination);
        return $this->getViewProductsWithPrice($products);
    }

    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository->getProductsByIds($productIds, $pagination);

        return $this->getViewProductsWithPrice($products);
    }

    public function getAllProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository->getAllProductsByIds($productIds, $pagination);
        return $this->getViewProductsWithPrice($products);
    }

    public function getRandomProducts($limit)
    {
        $products = $this->productRepository->getRandomProducts($limit);
        return $this->getViewProductsWithPrice($products);
    }

    /**
     * @param Entity\Product[] $products
     * @return View\Product[]
     */
    private function getViewProductsWithPrice($products)
    {
        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = $product->getView()
                ->withPrice($this->pricing)
                ->export();
        }

        return $viewProducts;
    }

    /**
     * @param Entity\Product[] $products
     * @return View\Product[]
     */
    private function getViewProducts($products)
    {
        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = $product->getView()
                ->export();
        }

        return $viewProducts;
    }

    /**
     * @param $productId
     * @return Entity\Product
     * @throws \LogicException
     */
    private function getProductAndThrowExceptionIfMissing($productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product === null) {
            throw new \LogicException('Missing Product');
        }

        return $product;
    }

    /**
     * @param string $tagId
     * @return Entity\Tag
     */
    private function getTagAndThrowExceptionIfMissing($tagId)
    {
        $tag = $this->tagRepository->find($tagId);

        if ($tag === null) {
            throw new \LogicException('Missing Tag');
        }

        return $tag;
    }
}
