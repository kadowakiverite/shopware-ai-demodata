<?php

namespace AIDemoData\Repository;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\Tax\TaxEntity;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class TaxRepository
{

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var SystemConfigService
     */
    private SystemConfigService $systemConfig;


    /**
     * @param EntityRepository $repository
     * @param SystemConfigService $systemConfig
     */
    public function __construct(EntityRepository $repository, SystemConfigService $systemConfig)
    {
        $this->repository = $repository;
        $this->systemConfig = $systemConfig;
    }


    /**
     * @param int $taxRate
     * @return TaxEntity
     */
    public function getTaxEntity(int $taxRate): TaxEntity
    {
        $criteria = (new Criteria())
            ->addFilter(new EqualsFilter('taxRate', $taxRate))
            ->setLimit(1);

        return $this->repository
            ->search($criteria, Context::createDefaultContext())
            ->first();
    }

    /**
     * @return TaxEntity
     */
    public function getDefaultTaxEntity(): TaxEntity
    {
        $defaultTaxRate = $this->systemConfig->get('core.tax.defaultTaxRate');
        $criteria = (new Criteria())
            ->addFilter(new EqualsFilter('id', $defaultTaxRate))
            ->setLimit(1);

        return $this->repository
            ->search($criteria, Context::createDefaultContext())
            ->first();
    }
}
