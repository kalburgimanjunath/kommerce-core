<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Warehouse
{
    public $id;
    public $name;
    public $created;
    public $updated;

    /* @var Address */
    public $address;

    public function __construct(Entity\Warehouse $warehouse)
    {
        $this->id      = $warehouse->getId();
        $this->name    = $warehouse->getName();
        $this->address = $warehouse->getAddress()->getView();
        $this->created = $warehouse->getCreated();
        $this->updated = $warehouse->getUpdated();
    }
}