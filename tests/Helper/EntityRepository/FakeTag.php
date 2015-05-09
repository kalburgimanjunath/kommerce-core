<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\TagInterface;
use inklabs\kommerce\Entity;

class FakeTag extends AbstractFake implements TagInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Tag);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function create(Entity\Tag & $tag)
    {
    }

    public function save(Entity\Tag & $tag)
    {
    }

    public function persist(Entity\Tag & $tag)
    {
    }
}