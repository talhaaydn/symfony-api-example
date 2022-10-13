<?php

namespace App\Service;

use App\Dto\ProductDto;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductService
{
    private ProductRepository $productRepository;

    private EntityManagerInterface $entityManager;

    private PaginationService $paginationService;

    public function __construct(
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager,
        PaginationService $paginationService
    )
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->paginationService = $paginationService;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function list(Request $request): array
    {
        $page = $request->get('page', $this->paginationService->getDefaultPage());
        $limit = $request->get('limit', $this->paginationService->getDefaultLimit());

        $pagination = $this->productRepository->listOfProducts($page, $limit);

        return $this->paginationService->paginate($pagination, $page, $limit, 'api_product_list');
    }

    /**
     * @param int $productId
     * @return Product|null
     */
    public function find(int $productId): ?Product
    {
        return $this->productRepository->findOneBy([
            'id' => $productId,
            'deletedAt' => null
        ]);
    }

    /**
     * @param ProductDto $productDto
     * @return Product
     */
    public function create(ProductDto $productDto): Product
    {
        $product = new Product();
        $product->setName($productDto->name);
        $product->setPrice($productDto->price);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    /**
     * @param Product $product
     * @param ProductDto $productDto
     * @return Product
     */
    public function update(Product $product, ProductDto $productDto): Product
    {
        $product->setName($productDto->name);
        $product->setPrice($productDto->price);

        $this->entityManager->flush();

        return $product;
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function delete(Product $product): Product
    {
        $product->setDeletedAt(new \DateTime());

        $this->entityManager->flush();

        return $product;
    }
}