<?php

declare(strict_types=1);

namespace InteractiveValues\TwErsatzteilservice\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Core\Environment;
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
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->getUploadedFiles()['csv_file'] ?? null;
        $finalPath = '';
//        if ($uploadedFile) {
//            $newName = time() . '_' . $uploadedFile->getClientFilename();
//            $finalPath = $this->uploadDir . $newName;
//            $uploadedFile->moveTo($finalPath);
//        }

        $finalPath = '/var/www/html/var/tx_twersatzteilservice/import/1704825785_produkt_ersatzteil_100730.csv'


        $this->view->assignMultiple([
        ]);
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
