<?php
/**
 * Data
 * @package lib-model-mysql
 * @version 0.0.1
 */

namespace LibModelMysql\Library;

class Data
{

    static function test(string $model, array $data): array {
        $result = [
            'data_create' => []
        ];

        foreach($data as $field => $rows){
            foreach($rows as $row){
                $exists = $model::getOne([$field=>$row[$field]]);
                if($exists)
                    continue;
                $result['data_create'][] = $row;
            }
        }

        if($result['data_create'])
            return $result;
        return [];
    }
}