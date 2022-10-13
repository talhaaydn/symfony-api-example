<?php

namespace App\Service;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaginationService
{
    private int $defaultPage = 1;
    private int $defaultLimit = 50;

    private UrlGeneratorInterface $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function paginate(PaginationInterface $pagination, int $page, int $limit, string $routeName): array
    {
        $items = $pagination->getItems();
        $total = $pagination->getTotalItemCount();
        $count = count($items);

        $lastPage = $this->findLastPage($total, $limit);

        return [
            'total' => $total,
            'count' => $count,
            'items' => $items,
            '_links' => [
                'prev' => $this->findPrevUrl($routeName, $page),
                'self' => $this->findSelfUrl($routeName, $page),
                'next' => $this->findNextUrl($routeName, $page, $lastPage)
            ]
        ];
    }

    /**
     * @return int
     */
    public function getDefaultPage(): int
    {
        return $this->defaultPage;
    }

    /**
     * @return int
     */
    public function getDefaultLimit(): int
    {
        return $this->defaultLimit;
    }

    private function findLastPage(int $total, int $limit): int
    {
        return (int) ceil($total / $limit);
    }

    private function findPrevUrl(string $routeName, int $page): ?string
    {
        $prev = null;

        if ($page > 1) {
            $prev = $this->router->generate($routeName, ['page' => $page - 1], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return $prev;
    }

    private function findSelfUrl(string $routeName, int $page): string
    {
        return $this->router->generate($routeName, ['page' => $page], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    private function findNextUrl(string $routeName, int $page, int $lastPage): ?string
    {
        $next = $this->router->generate($routeName, ['page' => $page + 1], UrlGeneratorInterface::ABSOLUTE_URL);

        if ($lastPage == $page) {
            return null;
        }

        return $next;
    }
}