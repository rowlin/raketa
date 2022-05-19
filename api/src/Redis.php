<?php


namespace App;


use Predis\Autoloader;
use Predis\Client;

class Redis implements ConnectionInterface
{

    protected $connection;

    public function __construct(array $data)
    {
        Autoloader::register();
        $this->connection = new Client($data);
    }

    public function __destruct(){
        $this->connection->disconnect();
    }

    /**
     * @return array
     */

    public function getData(): array
    {
        $list =$this->connection->keys('*');
        sort($list);
        $data = [];
        foreach ($list as $key)
        {
            $value = $this->connection->get($key);
            $data[$key] = $value;
        }
        return $data;
    }

    /**
     * @param RequestChoose $data
     * @return int
     */

    public function setData(RequestChoose $data) : int
    {
       $res  = 500;
       if($this->connection->set($data->request->key, $data->request->value , "EX" , 3600)->getPayload() === "OK")
          $res = 200;
       return $res;
    }

    /**
     * @return int
     */
    public function flushData(): int
    {
        $res  = 500;
        if($this->connection->flushAll())
            $res  = 200 ;
        return $res;
    }

    /**
     * @param RequestChoose $data
     * @return int [code]
     */

    public function deleteData(RequestChoose $data) : int
    {
        if($this->connection->exists($data->request->key)) {
                $this->connection->del($data->request->key);
                return  200;
        }
        else return  404;
    }
}
