<?php
/**
 * IndexDescriptor
 * @package lib-model-mysql
 * @version 0.0.1
 */

namespace LibModelMysql\Library;

class IndexDescriptor
{

    static function describe(string $model): array {
        $sql = $model::putFrom('SHOW INDEXES (:from)');
        $indexes = $model::query($sql, 'write');
        if(!$indexes)
            return null;

        $result = [];

        foreach($indexes as $index){
            $name = $index->Key_name;

            if(!isset($result[$name])){
                $result[$name] = [
                    'name' => $name,
                    'type' => $index->Index_type,
                    'fields' => []
                ];
            }

            $idx = [];
            if($index->Sub_part)
                $idx['length'] = $index->Sub_part;
            $field = $index->Column_name;

            $result[$name]['fields'][$field] = $idx;
        }

        return $result;
    }
}