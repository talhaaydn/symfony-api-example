<?php

namespace App\Controller\Api;

use App\Controller\Api\Traits\ResponseTrait;
use App\Dto\ProductDto;
use App\Service\ProductService;
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
class ProductController extends AbstractFOSRestController
{
    use ResponseTrait;

    // TODO: API Documentation will be update
    /**
     * @Rest\Route(path="/product", name="api_product_list", methods={"GET"})
     * @OA\Response(
     *     response="200",
     *     description="Returns the products",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=Product::class))
     *     )
     * )
     * @OA\Tag(name="Products")
     */
    public function list(Request $request, ProductService $productService): View
    {
        dd($this->getUser());

        $products = $productService->list($request);


        return $this->response($products, true, Response::HTTP_OK);
    }

    // TODO: API Documentation will be update
    /**
     * @Rest\Route(path="/product/{id}", name="api_product_find", methods={"GET"})
     * @OA\Response(
     *     response="200",
     *     description="Returns the product"
     * )
     * @OA\Tag(name="Products")
     */
    public function find(int $id, ProductService $productService): View
    {
        $product = $productService->find($id);

        if ($product === null) {
            return $this->response(null, false, Response::HTTP_NOT_FOUND);
        }

        return $this->response(['product' => $product], true, Response::HTTP_OK);
    }

    // TODO: API Documentation will be update

    /**
     * @Rest\Route(path="/product/{id}", name="api_product_store", methods={"POST"})
     * @ParamConverter("productDto", converter="fos_rest.request_body")
     *
     * @OA\Response(
     *     response="201",
     *     description="Create a new product",
     * )
     * @OA\RequestBody(@Model(type=ProductDto::class, groups={"create"}))
     * @OA\Tag(name="Products")
     *
     * @param ProductDto $productDto
     * @param ProductService $productService
     * @param ConstraintViolationListInterface $validationErrors
     * @return View
     */
    public function store(
        ProductDto $productDto,
        ProductService $productService,
        ConstraintViolationListInterface $validationErrors
    ): View
    {
        if (\count($validationErrors) > 0) {
            return $this->response([], false, Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        $product = $productService->create($productDto);

        return $this->response(['product' => $product], true, Response::HTTP_CREATED);
    }

    // TODO: API Documentation will be update
    /**
     * @Rest\Route(path="/product/{id}", name="api_product_update", methods={"PUT"})
     * @ParamConverter("productDto", converter="fos_rest.request_body")
     *
     * @OA\Response(
     *     response="200",
     *     description="Update the product",
     * )
     * @OA\RequestBody(@Model(type=ProductDto::class, groups={"update"}))
     * @OA\Tag(name="Products")
     *
     * @param Product $product
     * @param ProductDto $productDto
     * @param ProductService $productService
     * @param ConstraintViolationListInterface $validationErrors
     * @return View
     */
    public function update(
        Product $product,
        ProductDto $productDto,
        ProductService $productService,
        ConstraintViolationListInterface $validationErrors
    )
    {
        if (\count($validationErrors) > 0) {
            return $this->response([], false, Response::HTTP_BAD_REQUEST, $validationErrors);
        }

        $product = $productService->update($product, $productDto);

        return $this->response(['product' => $product], true, Response::HTTP_OK);
    }

    // TODO: API Documentation will be update
    /**
     * @Rest\Route(path="/product/{id}", name="api_product_delete", methods={"DELETE"})
     * @OA\Response(
     *     response="200",
     *     description="Delete the product",
     * )
     * @OA\Tag(name="Products")
     *
     * @param Product $product
     * @param ProductService $productService
     * @return View
     */
    public function delete(
        Product $product,
        ProductService $productService
    )
    {
        $productService->delete($product);

        return $this->response([], true, Response::HTTP_OK);
    }
}
