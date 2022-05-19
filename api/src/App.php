<?php

namespace App;


class App
{

    protected $connection;

    public function __construct(array $config ){
        $connection  = new Connection($config);
        $connection->makeRequest(new RequestChoose($config['connection']));
    }

}
