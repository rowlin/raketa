<?php


namespace App;


class Cli implements ResponseInterface
{

    const AVAILABLE_METHODS = ['add' , 'delete'];

    public $method;
    public $provider;
    public $key;
    public $value;
    public $status;


    public function __construct(){
            $this->provider = $_SERVER['argv'][1] ?? NULL;
            $this->method = ( isset($_SERVER['argv'][2]) && in_array(strtolower($_SERVER['argv'][2]) , self::AVAILABLE_METHODS)) ? strtolower($_SERVER['argv'][2]) : NULL ;
            $this->key = $_SERVER['argv'][3] ?? NULL;
            $this->value = (isset($_SERVER['argv'][2]) && (strtolower($_SERVER['argv'][2] )) ===  'add') ? $_SERVER['argv'][4] : NULL;
            $this->status = ( isset($_SERVER['argv'][2]) &&  in_array( strtolower($_SERVER['argv'][2]) , self::AVAILABLE_METHODS))  ? 200 : 500 ;
    }

    /**
     * @param string $provider
     */

    public function setProvider( string $provider) : void {
        if($this->provider !== null && strtolower($this->provider) !== $provider){
            $this->status = 500;
        }
    }

    /**
     * @param $data
     * @return string
     */

    public function response(mixed $data) : string
    {
        $res = $this->error();
            switch($this->status){
                case 500 :
                    $res = "Oops.";
                    break;
                case 404 :
                   $res = "Not found";
                   break;
                case 200 :
                    $res = "OK";
                    break;
                default:
                   break;
            }
        return $res;
    }

    /**
     * @param null $data
     */

    public function error($data = null)
    {
        return isset($data) ??
            "Команда добавления: $ ./command redis add {key} {value}". PHP_EOL .
            "Команда удаления: $ ./command redis delete {key}" . PHP_EOL ;
    }

}
