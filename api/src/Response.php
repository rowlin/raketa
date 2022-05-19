<?php


namespace App;


class Response implements ResponseInterface
{

    const AVAILABLE_METHODS = [ "get" , "delete"];

    public $method;
    public $provider;
    public $key;
    public $value;
    public $status;

    public function __construct(){
        $uri = explode('/',$_SERVER['REQUEST_URI']);
        $this->provider = isset($uri[2]) ?  strtolower($uri[2]) : NUll ;
        $this->method = in_array(strtolower($_SERVER['REQUEST_METHOD']) , self::AVAILABLE_METHODS) ? strtolower($_SERVER['REQUEST_METHOD']) : NULL ;
        $this->key = $uri[3] ?? NULL;
        $this->value =  NULL;
        $this->status = (isset($uri[1]) &&
            $uri[1] === 'api' &&
            in_array(strtolower($_SERVER['REQUEST_METHOD']) , self::AVAILABLE_METHODS)) ? 200 : 500; ;
    }

    public function setProvider( string $provider) : void {
        if($this->provider !== null && strtolower($this->provider) !== $provider){
            $this->status = 500;
        }
    }

    public function response(mixed $data) :string
    {
        $res = [
            'status' => (bool)($this->status == 200),
            'code' => $this->status ,
            'data' => $data ?? []
        ];
        header("Content-Type: application/json");
        http_response_code($this->status);
        return json_encode($res);
    }

    public function error($data = null): string
    {
        return  isset($data) ? $data : "Oops";
    }

}
