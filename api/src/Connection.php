<?php


namespace App;


class Connection
{
    protected $config;
    protected $connection;

    public function __construct(array $config){
        $this->config = $config;
        if(isset($config['connection']) && isset($config['config'])){
            switch($config['connection']){
                case 'redis' :
                    $this->connection = new Redis($config['config']);
                    break;
                case 'memcached':
                    $this->connection = new Memcached($config['config']);
                    break;
                default:
                    echo 'Connection not found';
                    break;
            }
        }else{
            return new \Exception('Cache provider not set. Please check config file');
        }
    }


    public function makeRequest(RequestChoose $request){
        if($request->request->status !== 500) {
            switch ($request->request->method) {
                case "add":
                    $request->request->status = $this->connection->setData($request);
                    break;
                case "delete":
                    $request->request->status = $this->connection->deleteData($request);
                    if($request->request->status === 404) {
                        $res = ['message' => "Data not exists"];
                    }
                    break;
                case "get":
                    $res = $this->connection->getData();
                    if (sizeof($res) == 0) {
                        $request->request->status = 404;
                        $res = ['message' => "Data not found"];
                    } else
                        $request->request->status = 200;
                    break;
                case "flush":
                    $request->request->status = $this->connection->flushData();
                    break;
                default:
                    $request->request->status = 404;
                    break;
            }
        }

        echo $request->request->response($res ?? []);
        exit();
    }

}
