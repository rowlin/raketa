<?php


namespace App;


interface ResponseInterface
{

    public function response(mixed $data) :string;

    public function error(string $data = null);

}
