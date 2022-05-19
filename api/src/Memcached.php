<?php


namespace App;



class Memcached implements ConnectionInterface
{

    public function __construct(array $data)
    {
    }

    public function getData() : array
    {
        // TODO: Implement getData() method.
        return  [];
    }

    public function setData(RequestChoose $data) : int
    {
        // TODO: Implement setData() method.
        return 0;
    }

    public function flushData() : int
    {
        // TODO: Implement flushData() method.
        return 0;
    }

    public function deleteData(RequestChoose $data) : int
    {
        // TODO: Implement deleteData() method.
        return 0;
    }
}
