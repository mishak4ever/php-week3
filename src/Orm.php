<?php

namespace Base;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

const CONNECTION_DEFAULT = 'default';

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'php.529252.ru',
    'username' => 'php.529252.ru',
    'password' => 'wyFJrvf5SFJY',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
        ], CONNECTION_DEFAULT);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$capsule->getConnection(CONNECTION_DEFAULT)->enableQueryLog();

// Проверка на существование полей для ORM
if (!Capsule::schema()->hasColumn('users', 'is_admin')) {
    Capsule::schema()->table('users', function (Blueprint $table) {
        $table->tinyInteger('is_admin')->default(0);
    });
}

function printLog()
{
    echo '<pre>';
    foreach ([CONNECTION_DEFAULT, CONNECTION_SECOND] as $name) {
        $log = Capsule::connection($name)->getQueryLog();
        foreach ($log as $elem) {
            echo $name . ':' . 0.01 * $elem['time'] . ': ' . $elem['query'] . ' bind: ' . json_encode($elem['bindings']) . '<br>';
        }
    }
    echo '</pre>';
}
