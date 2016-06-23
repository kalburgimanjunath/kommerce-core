<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface OptionServiceInterface
{

    public function create(Option & $option);
    public function update(Option & $option);
    public function createOptionValue(OptionValue & $optionValue);

    /**
     * @param UuidInterface $id
     * @return Option
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Option[]
     */
    public function getAllOptions($queryString = null, Pagination &$pagination = null);
}
