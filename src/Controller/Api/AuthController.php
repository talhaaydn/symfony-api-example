<?php

namespace App\Controller\Api;

use App\Controller\Api\Traits\ResponseTrait;
use App\Dto\ProductDto;
use App\Dto\UserDto;
use App\Service\ProductService;
use App\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use OpenApi\Annotations as OA;
use App\Entity\Product;

/**
 * @Route("/api")
 */
class AuthController extends AbstractFOSRestController
{
    use ResponseTrait;

    /**
     * @Route("/register", name="api_register", methods={"POST"})
     *
     * @ParamConverter("userDto", converter="fos_rest.request_body")
     * @OA\RequestBody(@Model(type=UserDto::class, groups={"create"}))
     *
     */
    public function register(UserDto $userDto, UserService $userService): View
    {
        $user = $userService->register($userDto);

        return $this->response(['user' => $user], true, Response::HTTP_CREATED);
    }
}
