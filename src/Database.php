<?php

namespace Maoshu\Engine;

use think\facade\Db;

class Database
{
    public static function initialize(array $config)
    {
        Db::setConfig([
            'default' => 'mysql',
            'connections' => [
                'mysql' => $config
            ]
        ]);
    }
}