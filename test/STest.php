<?php

class STest extends TestCase
{
    private $connection;

    public function setUp()
    {
        parent::setUp();

        $this->connection = new \Sql\Connection();
    }

    public function testA()
    {
        $query = new \Sql\Query();
        $environment = new \Sql\Environment();

        $sql = $query->ors(new \Sql\OperationContainer(array(
            $query->equal(
                $query->constant('a'),
                $query->constant('b')
            )
        )));

        print_r($sql->run($environment));
    }
}