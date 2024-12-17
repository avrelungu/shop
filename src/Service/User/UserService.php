<?php

namespace App\Service\User;

use App\Dto\UserDto;
use App\Entity\Order;
use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    public function __construct(
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function create(User $user): User
    {
        $this->validateUser($user);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        return $user;
    }

    private function validateUser(User $user)
    {
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $failingProperties = [];

            foreach ($errors as $error) {
                $failingProperties[] = $error->getPropertyPath();
            }

            throw new BadRequestException(
                'Invalid properties for ' . get_class($user) . ' creation: '
                . implode(', ', $failingProperties),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}