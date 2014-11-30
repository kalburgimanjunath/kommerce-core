<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use Doctrine\ORM\EntityManager;

class Tag extends Lib\EntityManager
{
    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     * @return Entity\View\Tag
     */
    public function find($id)
    {
        /* @var Entity\Tag $entityTag */
        $entityTag = $this->entityManager->getRepository('inklabs\kommerce\Entity\Tag')->find($id);

        if ($entityTag === null or ! $entityTag->getIsActive()) {
            return null;
        }

        return Entity\View\Tag::factory($entityTag)
            ->export();
    }
}
