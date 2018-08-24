<?php
/**
 * QueryData
 * @package lib-model-mysql
 * @version 0.0.1
 */

namespace LibModelMysql\Library;

class QueryData
{

    static function dataCreateSingle(string $model, array $row): string{
        $sql = 'INSERT INTO (:table) ( (:fields) ) VALUES (:values);';

        $sql = $model::putTable($sql, [
            'table' => $model::getTable()
        ]);
        $sql = $model::putField($sql, [
            'fields' => array_keys($row)
        ]);
        $sql = $model::putValue($sql, [
            'values' => array_values($row)
        ]);

        return $sql;
    }

    static function dataCreate(string $model, array $rows): string {
        $tx = '';
        foreach($rows as $row)
            $tx.= self::dataCreateSingle($model, $row) . PHP_EOL;

        return $tx;
    }
}