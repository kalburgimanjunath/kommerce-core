<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;

interface CouponServiceInterface
{
    public function create(Coupon & $coupon);
    public function update(Coupon & $coupon);

    /**
     * @param Coupon $coupon
     */
    public function delete(Coupon $coupon);

    /**
     * @param int $id
     * @return Coupon
     * @throws EntityNotFoundException
     */
    public function findOneById($id);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCoupons($queryString = null, Pagination & $pagination = null);

    /**
     * @param int[] $couponIds
     * @param Pagination $pagination
     * @return Coupon[]
     */
    public function getAllCouponsByIds($couponIds, Pagination & $pagination = null);
}