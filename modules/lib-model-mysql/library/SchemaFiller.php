<?php
/**
 * SchemaFiller
 * @package lib-model-mysql
 * @version 0.0.1
 */

namespace LibModelMysql\Library;

class SchemaFiller
{

    private static $opt_by_type = [
        'BIGINT' => [
            'length' => 20
        ],

        'BOOLEAN' => [
            'length' => 1
        ],

        'CHAR' => [
            'length' => 1
        ],

        'DATE' => [],

        'DATETIME' => [],

        'DECIMAL' => [
            'length' => '10,0'
        ],

        'DOUBLE' => [],

        'ENUM' => [],

        'FLOAT' => [],

        'INTEGER' => [
            'length' => 11
        ],

        'LONGTEXT' => [],

        'MEDIUMINT' => [
            'length' => 9
        ],

        'SET' => [],

        'SMALLINT' => [
            'length' => 6
        ],

        'TEXT' => [],

        'TIMESTAMP' => [
            'attrs' => [
                'null' => false
            ]
        ],

        'TIME' => [],

        'TINYINT' => [
            'length' => 4
        ],

        'TINYTEXT' => [],

        'VARCHAR' => [
            'length' => 50
        ],

        'YEAR' => [
            'length' => 4
        ],
    ];

    static function index(array $indexes, array $fields): array{
        $index_default = [
            'type' => 'BTREE',
            'fields' => []
        ];

        foreach($indexes as $name => &$index){
            $index['name'] = $name;
            $index = array_replace($index_default, $index);
        }
        unset($index);

        // get default indexes from fields ( primary_key and unique )
        foreach($fields as $name => $field){
            $unique = $field['attrs']['unique'] ?? false;
            $primary = $field['attrs']['primary_key'] ?? false;

            if($primary){
                $indexes['PRIMARY'] = [
                    'name' => 'PRIMARY',
                    'type' => 'BTREE',
                    'fields' => [
                        $name => []
                    ]
                ];
            }

            if($unique){
                $indexes[$name] = [
                    'name' => $name,
                    'type' => 'BTREE',
                    'fields' => [
                        $name => []
                    ]
                ];
            }
        }

        return $indexes;
    }

    static function table(array $fields): array{
        $glob_opt = [
            'options' => [],
            'length' => null,
            'attrs' => [
                'null' => true,
                'default' => null,
                'update' => null,
                'unsigned' => false,
                'unique' => false,
                'primary_key' => false,
                'auto_increment' => false
            ]
        ];

        $opt_by_type = self::$opt_by_type;
        foreach($opt_by_type as $name => &$value)
            $value = array_replace_recursive($glob_opt, $value);
        unset($value);

        foreach($fields as &$field){
            $field['type'] = strtoupper($field['type']);
            if($field['type'] === 'INT')
                $field['type'] = 'INTEGER';
            $type = $field['type'];
            if(!isset($opt_by_type[$type]))
                continue;
            $def_vals = $opt_by_type[$type];
            $field = array_replace_recursive($def_vals, $field);

            // custom fix
            // not null for primary key
            if($field['attrs']['primary_key'])
                $field['attrs']['null'] = false;

            // length 10 for unsigned integer
            if($field['attrs']['unsigned']){
                if(!$field['length'])
                    $field['length'] = 10;
            }

            // tinyint is for boolean
            if($type === 'BOOLEAN'){
                $field['type'] = 'TINYINT';
                if(!is_null($field['attrs']['default']))
                    $field['attrs']['default'] = (int)$field['attrs']['default'];
            }
        }
        unset($field);

        return $fields;
    }
}