<?php

namespace KevinPhung\SortOutOfStock\Plugin\Elasticsearch\Adapter\FieldMapper\Product\FieldProvider;

use Magento\Elasticsearch\Model\Adapter\FieldMapper\Product\FieldProvider\DynamicField as CoreDynamicField;
use Magento\Elasticsearch\Model\Adapter\FieldMapper\Product\FieldProvider\FieldType\ConverterInterface
    as FieldTypeConverterInterface;
use KevinPhung\SortOutOfStock\Model\Adapter\Product\BatchDataMapper\StockStatusFieldsProvider;

/**
 * class DynamicField
 */
class DynamicField
{
    /**
     * @var FieldTypeConverterInterface
     */
    private $fieldTypeConverter;

    /**
     * @param FieldTypeConverterInterface $fieldTypeConverter
     */
    public function __construct(FieldTypeConverterInterface $fieldTypeConverter)
    {
        $this->fieldTypeConverter = $fieldTypeConverter;
    }

    /**
     * Add dynamic SRP sell unit
     *
     * @param CoreDynamicField $subject
     * @param array $result
     * @return array
     */
    public function afterGetFields(CoreDynamicField $subject, $result)
    {
        $result[StockStatusFieldsProvider::STOCK_STATUS] = [
            'type' => $this->fieldTypeConverter->convert(FieldTypeConverterInterface::INTERNAL_DATA_TYPE_INT),
            'store' => true
        ];

        return $result;
    }
}
