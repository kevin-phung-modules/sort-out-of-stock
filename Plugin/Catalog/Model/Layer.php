<?php

namespace KevinPhung\SortOutOfStock\Plugin\Catalog\Model;

use KevinPhung\SortOutOfStock\Model\Adapter\Product\BatchDataMapper\StockStatusFieldsProvider;

/**
 * class Layer
 */
class Layer
{
    /**
     * @param \Magento\Catalog\Model\Layer $subject
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $result
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function afterGetProductCollection(\Magento\Catalog\Model\Layer $subject, $result)
    {
        $result->setOrder(StockStatusFieldsProvider::STOCK_STATUS, StockStatusFieldsProvider::SORT_DIR);

        return $result;
    }
}
