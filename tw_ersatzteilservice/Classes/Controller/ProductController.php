<?php
declare(strict_types=1);

namespace InteractiveValues\TwErsatzteilservice\Controller;

use InteractiveValues\TwErsatzteilservice\Domain\Model\Dto\Filter;
use InteractiveValues\TwErsatzteilservice\Domain\Repository\ProductRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ProductController extends ActionController
{

    protected ProductRepository $productRepository;

    public function initializeAction()
    {
        $this->productRepository = GeneralUtility::makeInstance(ProductRepository::class);
    }

    public function indexAction(Filter $filter = null): void
    {
        if ($filter === null) {
            $filter = new Filter();
        };

        $this->view->assignMultiple([
            'filter' => $filter,
            'sortiment' => $this->productRepository->getSortiment(),
            'modelgroups' => $this->productRepository->getModelGroups($filter),
            'products' => $this->productRepository->getProducts($filter),
        ]);
    }

    public function productAction(int $product = 0): void
    {
        $this->view->assignMultiple([
            'product' => $this->productRepository->getProductById($product),
            'spareparts' => $this->productRepository->getSpareParts($product),
        ]);
    }

}