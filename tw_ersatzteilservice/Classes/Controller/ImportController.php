<?php

declare(strict_types=1);

namespace InteractiveValues\TwErsatzteilservice\Controller;

use InteractiveValues\TwErsatzteilservice\Domain\Repository\ProductRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3Fluid\Fluid\View\ViewInterface;


class ImportController
{
    protected ModuleTemplate $moduleTemplate;
    protected ViewInterface $view;

    protected string $uploadDir;
    protected ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = GeneralUtility::makeInstance(ProductRepository::class);
        $this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->uploadDir = Environment::getVarPath() . '/tx_twersatzteilservice/import/';
        GeneralUtility::mkdir_deep($this->uploadDir);
    }

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $action = $request->getParsedBody()['action'] ?? $request->getQueryParams()['action'] ?? 'overview';
        $actionMethod = $action . 'Action';
        $this->initializeView($action);
        $this->$actionMethod($request);
        $this->moduleTemplate->setContent($this->view->render());
        return new HtmlResponse($this->moduleTemplate->renderContent());
    }

    protected function overviewAction(ServerRequestInterface $request): void
    {
    }

    protected function previewAction(ServerRequestInterface $request): void
    {
        $modification = (float)($request->getParsedBody()['price'] ?? 0);

        if ($modification !== 0) {
            $rows = $this->productRepository->getAllPriceRows();
            foreach ($rows as &$row) {
                $newPrize = $this->calculateModifiedPrice($row['preis'], $modification);
                $row['preis_new'] = $newPrize;
            }
            $this->view->assignMultiple([
                'price' => $modification,
                'rows' => $rows,
            ]);
        }
    }

    protected function updatePriceAction(ServerRequestInterface $request): void
    {
        $modification = (float)($request->getQueryParams()['price'] ?? 0);
        if ($modification !== 0) {
            $rows = $this->productRepository->getAllPriceRows();
            foreach ($rows as &$row) {
                $newPrice = $this->calculateModifiedPrice($row['preis'], $modification);
                $this->productRepository->updatePrice($row['uid'], $newPrice);
            }
            $this->view->assignMultiple([
                'price' => $modification,
                'rows' => $rows,
            ]);
        }
    }

    protected function calculateModifiedPrice($preis, float $modification): string
    {
        $oldPrize = str_replace(",", ".", $preis);
        if ($modification > 0) {
            $percentChange = 1 + $modification / 100;
        } else {
            $percentChange = 1 - $modification * (-1) / 100;
        }
        $new = $oldPrize * $percentChange;
        $new = round($new, 1);
        $new = str_replace('.', ',', (string)$new);
        return $new;
    }

    protected function initializeView(string $templateName): void
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplate($templateName);
        $this->view->setTemplateRootPaths(['EXT:tw_ersatzteilservice/Resources/Private/Templates/Import']);
        $this->view->setPartialRootPaths(['EXT:tw_ersatzteilservice/Resources/Private/Partials']);
        $this->view->setLayoutRootPaths(['EXT:tw_ersatzteilservice/Resources/Private/Layouts']);
    }

    protected function getBackendUserAuthentication(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
