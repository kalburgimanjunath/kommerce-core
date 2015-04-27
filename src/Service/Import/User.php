<?php
namespace inklabs\kommerce\Service\Import;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;

class User
{
    /** @var EntityRepository\User */
    private $userRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->userRepository = $entityManager->getRepository('kommerce:User');
    }

    /**
     * @param \Iterator $iterator
     * @return int
     */
    public function import(\Iterator $iterator)
    {
        $importedCount = 0;
        foreach ($iterator as $key => $row) {
            if ($key < 2 && $row[0] === 'id') {
                continue;
            }

            $externalId = $row[0];
            $name = $row[1];
            $address = $row[2];
            $zip5 = $row[3];
            $city = $row[4];
            $phone = $row[5];
            $fax = $row[6];
            $url = $row[7];
            $email = $row[8];

            $firstName = $this->parseFirstName($name);
            $lastName = $this->parseLastName($name);

            $user = new Entity\User;
            $user->setExternalId($externalId);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);

            if (! empty($email)) {
                $user->setEmail($email);
            }

            $this->entityManager->persist($user);
            $importedCount++;
        }

        $this->entityManager->flush();

        return $importedCount;
    }

    /**
     * @param string $name
     * @return string
     */
    private function parseFirstName($name)
    {
        $firstName = '';

        $namePieces = explode(' ', $name);
        if (! empty($namePieces)) {
            $firstName = $namePieces[0];
        }

        return $firstName;
    }

    /**
     * @param string $name
     * @return string
     */
    private function parseLastName($name)
    {
        $lastName = '';

        $namePieces = explode(' ', $name);
        if (count($namePieces) > 1) {
            array_shift($namePieces);
            $lastName = implode(' ', $namePieces);
        }

        return $lastName;
    }
}
