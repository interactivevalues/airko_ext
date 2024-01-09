<?php

declare(strict_types=1);

namespace InteractiveValues\TwErsatzteilservice\Domain\Model\Dto;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Filter extends AbstractEntity
{

    public $sortiment = 0;
    public $modelgroup = 0;
    public $product = 0;
}