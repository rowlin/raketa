<?php


namespace App;


interface ConnectionInterface
{

    public function __construct(array $data);

    public function getData() : array;

    public function setData(RequestChoose $data);

    public function flushData();//TODO:

    public function deleteData(RequestChoose $data);

}
