<?php


namespace App;


class RequestChoose
{

    /*
        Команда добавления: $ ./command redis add {key} {value}
        Команда удаления: $ ./command redis delete {key}
     */

    public $request;

    public function __construct($connection){
        $is_console = PHP_SAPI == 'cli';
        if($is_console){
            $this->request  = new Cli();
            $this->request->setProvider($connection);
        }else{
            $this->request = new Response();
            $this->request->setProvider($connection);
        }
        return  $this->request;
    }

}
