<?php

namespace KevinPhung\SortOutOfStock\Plugin\Elasticsearch\Model\ResourceModel\Fulltext\Collection;

use Magento\Elasticsearch\Model\ResourceModel\Fulltext\Collection\SearchCriteriaResolver
    as SearchCriteriaResolverCore;
use KevinPhung\SortOutOfStock\Model\Adapter\Product\BatchDataMapper\StockStatusFieldsProvider;

/**
 * class SearchCriteriaResolver
 */
class SearchCriteriaResolver
{
    /**
     * @param SearchCriteriaResolverCore $subject
     * @param $searchCriteria
     * @return mixed
     */
    public function afterResolve(SearchCriteriaResolverCore $subject, $searchCriteria)
    {
        if (array_key_exists('personalized', $searchCriteria->getSortOrders() ?? [])) {
            $searchCriteria
                ->setSortOrders([StockStatusFieldsProvider::STOCK_STATUS => StockStatusFieldsProvider::SORT_DIR]);
        }

        return $searchCriteria;
    }
}
