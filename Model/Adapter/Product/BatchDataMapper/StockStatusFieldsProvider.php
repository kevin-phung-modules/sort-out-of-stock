<?php

namespace KevinPhung\SortOutOfStock\Model\Adapter\Product\BatchDataMapper;

use Magento\AdvancedSearch\Model\Adapter\DataMapper\AdditionalFieldsProviderInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Model\ResourceModel\Stock\Status;
use Zend_Db_Select;

class StockStatusFieldsProvider implements AdditionalFieldsProviderInterface
{
    /**
     * @const STOCK_IN_STOCK
     */
    const STOCK_IN_STOCK = 1;

    /**
     * @const STOCK_OUT_OF_STOCK
     */
    const STOCK_OUT_OF_STOCK = 2;

    /**
     * @const STOCK_STATUS
     */
    const STOCK_STATUS = 'stock_status';

    /**
     * @const TYPE_INTEGER
     */
    const TYPE_INTEGER = 'integer';

    /**
     * @const SORT_DIR
     */
    const SORT_DIR = Zend_Db_Select::SQL_ASC;

    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var array
     */
    private $inStockProductIds = [];

    /**
     * @var Status
     */
    private $stockStatusResource;

    /**
     * @param CollectionFactory $productCollectionFactory
     * @param Status $stockStatusResource
     */
    public function __construct(
        CollectionFactory $productCollectionFactory,
        Status $stockStatusResource
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->stockStatusResource = $stockStatusResource;
    }

    /**
     * @param array $productIds
     * @param int $storeId
     * @return array
     */
    public function getFields(array $productIds, $storeId)
    {
        $stockStatusDocumentData = [];
        $fieldName = self::STOCK_STATUS;
        foreach ($productIds as $productId) {
            if ($productId) {
                $stockStatus = $this->isProductInStock($productId, (int)$storeId);
                $stockStatusDocumentData[$productId][$fieldName] = $stockStatus;
            }
        }

        return $stockStatusDocumentData;
    }

    /**
     * @param int $entityId
     * @param int $storeId
     * @return int
     */
    private function isProductInStock(int $entityId, int $storeId): int
    {
        if (in_array($entityId, $this->getInStockProductIds($storeId))) {
            return self::STOCK_IN_STOCK;
        }

        return self::STOCK_OUT_OF_STOCK;
    }

    /**
     * @param int $storeId
     * @return array
     */
    private function getInStockProductIds($storeId): array
    {
        if (!isset($this->inStockProductIds[$storeId])) {
            $collection = $this->productCollectionFactory->create()->addStoreFilter($storeId);
            $this->stockStatusResource->addStockDataToCollection($collection, true);
            $this->inStockProductIds[$storeId] = $collection->getAllIds();
        }

        return $this->inStockProductIds[$storeId];
    }
}
