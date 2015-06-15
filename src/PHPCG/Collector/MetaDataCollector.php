<?php
/**
 * DWX 2015 - PHP Code Generator
 *
 * @link      https://github.com/RalfEggert/dwx2015-code-generierung
 * @copyright Copyright (c) 2015 Ralf Eggert
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace PHPCG\Collector;

use Zend\Db\Metadata\Metadata;
use Zend\Db\Metadata\Object\ColumnObject;

/**
 * Class MetaDataCollector
 *
 * @package PHPCG\Collector
 */
class MetaDataCollector
{
    /**
     * @var Metadata
     */
    private $metaData;

    /**
     * Constructor to initiate MetaDataCollector
     *
     * @param $metaData
     */
    public function __construct(Metadata $metaData)
    {
        $this->metaData = $metaData;
    }

    /**
     * Fetch columns for a table
     *
     * @param $tableName
     *
     * @return array
     */
    public function fetchTableColumns($tableName)
    {
        $tableColumns = array();

        try {
            $tableMeta = $this->metaData->getTable($tableName);
        } catch (\Exception $e) {
            return $tableColumns;
        }

        foreach ($tableMeta->getColumns() as $column) {
            /** @var $column ColumnObject */
            $config = array('required' => !$column->getIsNullable());

            if (in_array($column->getDataType(), array('varchar', 'text', 'enum'))) {
                $config['type'] = 'string';
            } else {
                $config['type'] = 'integer';
            }

            if ($column->getDataType() == 'varchar') {
                $config['max_length'] = $column->getCharacterMaximumLength();
            } elseif ($column->getDataType() == 'enum') {
                $config['values'] = $column->getErrata('permitted_values');
            }

            $tableColumns[$column->getName()] = $config;
        }

        return $tableColumns;
    }
}
