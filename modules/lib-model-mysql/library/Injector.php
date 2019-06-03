<?php
/**
 * Injector
 * @package lib-model-mysql
 * @version 0.0.3
 */

namespace LibModelMysql\Library;

use Cli\Library\Bash;

class Injector
{
    static function iConnection(array $config, bool $value): ?array{
        if(!$value)
            return null;

        $db_name = 'mim_' . strtolower($config['name']);
        $result = [
            'connections' => [
                'default' => [
                    'driver' => 'mysql',
                    'configs' => [
                        'main' => [
                            'host'   => Bash::ask(['text' => 'DB Hostname', 'default' => 'localhost']),
                            'user'   => Bash::ask(['text' => 'DB User',     'default' => get_current_user()]),
                            'passwd' => Bash::ask(['text' => 'DB Name',     'default' => $db_name])
                        ]
                    ]
                ]
            ]
        ];

        return $result;
    }
}