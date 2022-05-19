<?php


namespace Test;
use App\Redis;
use PHPUnit\Framework\TestCase;



class CliTest extends TestCase
{

    use HelpTrait;
    protected $connection;

    protected function setUp(): void
    {
        parent::setUp();
        $config = parse_ini_file("config/settings.ini");
        $this->connection = new Redis($config['config']);
    }

    protected function createKeyValue() : string
    {
        $key = $this->generateRandomString(5);
        $value = $this->generateRandomString(10);
        $res = exec( "php command.php redis add $key  $value");
        $this->assertEquals($res , "OK");
        return $key;
    }

    public function testSetKeyAndValueRedis() :void
    {
        $key = $this->createKeyValue();
        $data =  $this->connection->getData();
        $this->assertArrayHasKey($key , $data );
    }

    public function testDeleteByKeyRedis() :void
    {
        $key = $this->createKeyValue();
        $res = exec( "php command.php redis delete $key ");
        $this->assertEquals($res , "OK");
        $data = $this->connection->getData();
        $this->assertArrayNotHasKey($key , $data);
    }

    public function testSetKeyAndValueMemcached(){
        $res = exec( 'php command.php memcached key value');
        $this->assertEquals($res , 'Oops.');
    }




}
