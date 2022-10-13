<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function register(UserDto $userDto): User
    {
        $user = $this->userRepository->findOneBy(['email' => $userDto->email]);

        if ($user) {
            dd("User already exists");
        }

        $user = new User();
        $user->setEmail($userDto->email);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $userDto->password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}