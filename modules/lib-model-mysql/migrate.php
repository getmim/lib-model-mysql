<?php

return [
    'LibModelMysql\\Model\\TableMaster' => [
        'fields' => [
            'id' => [
                'type' => 'BIGINT',
                'attrs' => [
                    'unsigned' => true,
                    'primary_key' => true,
                    'auto_increment' => true
                ],
                'index' => 1000
            ],
            'model' => [
                'type' => 'VARCHAR',
                'length' => 150,
                'attrs' => [
                    'null' => false
                ],
                'index' => 2000
            ],
            'type' => [
                'type' => 'TINYINT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => true
                ],
                'index' => 3000
            ],
            'name' => [
                'type' => 'VARCHAR',
                'length' => 100,
                'attrs' => [
                    'null' => false
                ],
                'index' => 4000
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 9000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 10000
            ]
        ],
        'indexes' => [
            'by_model_name' => [
                'fields' => [
                    'model' => [],
                    'name' => []
                ]
            ]
        ]
    ]
];
