<?php
declare(strict_types=1);

namespace InteractiveValues\TwErsatzteilservice\Domain\Repository;

use InteractiveValues\TwErsatzteilservice\Domain\Model\Dto\Filter;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProductRepository
{

    public function getSortiment(): array
    {
        return $this->getQueryBuilder('tx_twersatzteilservice_sortiment')
            ->from('tx_twersatzteilservice_sortiment')
            ->select('*')
            ->orderBy('sorting')
            ->execute()
            ->fetchAllAssociative();
    }

    public function getModelGroups(Filter $filter): array
    {
        if ($filter->sortiment === 0) {
            return [];
        }

        $queryBuilder = $this->getQueryBuilder('tx_twersatzteilservice_modellgruppe');
        return $queryBuilder
            ->select('*')
            ->from('tx_twersatzteilservice_modellgruppe')
            ->where(
                $queryBuilder->expr()->eq('fid_sortiment', $queryBuilder->createNamedParameter($filter->sortiment, \PDO::PARAM_INT))
            )
            ->orderBy('sorting')
            ->execute()
            ->fetchAllAssociative();
    }

    public function getProducts(Filter $filter): array
    {
        if ($filter->sortiment === 0 || $filter->modelgroup === 0) {
            return [];
        }

        $queryBuilder = $this->getQueryBuilder('tx_twersatzteilservice_produkt');
        return $queryBuilder
            ->select('*')
            ->from('tx_twersatzteilservice_produkt')
            ->where(
//                $queryBuilder->expr()->eq('fid_sortiment', $queryBuilder->createNamedParameter($filter->sortiment, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('fid_modellgruppe', $queryBuilder->createNamedParameter($filter->modelgroup, \PDO::PARAM_INT))
            )
            ->orderBy('bezeichnung')
            ->execute()
            ->fetchAllAssociative();
    }

    public function getProductById(int $productId): array
    {
        $queryBuilder = $this->getQueryBuilder('tx_twersatzteilservice_produkt');
        $row = $queryBuilder
            ->select('*')
            ->from('tx_twersatzteilservice_produkt')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($productId, \PDO::PARAM_INT))
            )
            ->setMaxResults(1)
            ->execute()
            ->fetchAssociative();

        if (is_array($row)) {
            $imagePath = Environment::getPublicPath() . '/fileadmin/kundendaten/ersatzteilservice/' . $row['bestellnummer'] . '.jpg';
            if (is_file($imagePath)) {
                $row['image'] = 'fileadmin/kundendaten/ersatzteilservice/' . $row['bestellnummer'] . '.jpg';
            }
        }
        return $row;
    }

    public function getSpareParts(int $productId): array
    {
        $queryBuilder = $this->getQueryBuilder('tx_twersatzteilservice_produkt_ersatzteil');
        $rows = $queryBuilder
            ->select('*')
            ->from('tx_twersatzteilservice_produkt_ersatzteil')
            ->join(
                'tx_twersatzteilservice_produkt_ersatzteil',
                'tx_twersatzteilservice_ersatzteil',
                'ersatzteil',
                $queryBuilder->expr()->eq('ersatzteil.uid', 'tx_twersatzteilservice_produkt_ersatzteil.ersatzteilbezeichnung')
            )
            ->where(
                $queryBuilder->expr()->eq('produkt', $queryBuilder->createNamedParameter($productId, \PDO::PARAM_INT))
            )
            ->orderBy('posnummer')
            ->execute()
            ->fetchAllAssociative();

        foreach ($rows as &$row) {
            $row['gueltigbis'] = trim($row['gueltigbis']);
            $row['preis'] = (float)(str_replace(',', '.', $row['preis']));
        }
        return $rows;
    }

    protected function getQueryBuilder(string $tableName): QueryBuilder
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tableName);
    }


}