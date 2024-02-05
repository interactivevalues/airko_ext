<?php

declare(strict_types=1);

namespace InteractiveValues\TwErsatzteilservice\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Http\UploadedFile;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3Fluid\Fluid\View\ViewInterface;


class ImportController
{
    protected ModuleTemplate $moduleTemplate;
    protected ViewInterface $view;

    protected string $uploadDir;

    public function __construct()
    {
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
        $this->view->assignMultiple([
        ]);
    }

    protected function previewAction(ServerRequestInterface $request): void
    {
        $price = (float)($request->getParsedBody()['price'] ?? 0);

        if ($price !== 0) {
            $rows = $this->getAllPriceRows();
            foreach ($rows as &$row) {
                $surchargeAmount = (float)($row['preis'] * $price) / 100;
                $row['preis_new'] = round($row['preis'] + $surchargeAmount, 2);
            }
            $this->view->assignMultiple([
                'price' => $price,
                'rows' => $rows,
            ]);
        }
    }

    protected function updatePriceAction(ServerRequestInterface $request): void
    {
        $price = (float)($request->getQueryParams()['price'] ?? 0);
        if ($price !== 0) {
            $rows = $this->getAllPriceRows();
            foreach ($rows as &$row) {
                $surchargeAmount = (float)($row['preis'] * $price) / 100;
                $priceNew = round($row['preis'] + $surchargeAmount, 2);
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_twersatzteilservice_ersatzteil');
                $queryBuilder
                    ->update('tx_twersatzteilservice_ersatzteil')
                    ->where(
                        $queryBuilder->expr()->eq('uid', $row['uid'])
                    )
                    ->set('preis', $priceNew)
                    ->execute();
            }
            $this->view->assignMultiple([
                'price' => $price,
                'rows' => $rows,
            ]);
        }
    }

    protected function getAllPriceRows()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_twersatzteilservice_ersatzteil');
        $rows = $queryBuilder
            ->select('*')
            ->from('tx_twersatzteilservice_ersatzteil')
            ->where(
                $queryBuilder->expr()->isNotNull('preis')
            )
            ->execute()
            ->fetchAllAssociative();
        return $rows;
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
