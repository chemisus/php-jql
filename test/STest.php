<?php

class STest extends TestCase
{
    /**
     * @var \Sql\Database
     */
    private $database;

    public function setUp()
    {
        parent::setUp();

        $this->database = new \Sql\Database();
    }

    public function testA()
    {
        $query = new \Sql\Query();
        $environment = new \Sql\Environment($this->database);

        $sql = $query->ors(new \Sql\OperationContainer(array(
            $query->equal(
                $query->constant('a'),
                $query->constant('b')
            )
        )));

//        print_r($sql->run($environment));
    }

    public function testSelect()
    {
        $query = new \Sql\Query();
        $environment = new \Sql\Environment($this->database);

        $sql = $query->select(
            new \Sql\OperationContainer(array($query->entity('name'))),
            $query->entity('products'),
            new \Sql\OperationContainer(array()),
            $query->ors(new \Sql\OperationContainer(array(
                $query->ands(new \Sql\OperationContainer(array(
                    $query->equal($query->entity('name'), $query->param('name')),
                ))),
            )))
        );

//        print_r($sql->run($environment));
//        print_r($this->database->prepare($sql->run($environment))->execute(array('name' => 'Chart Radio')));
    }

    public function testQueryBuilder()
    {
        $query = new \Sql\Query();
        $environment = new \Sql\Environment($this->database);

        $q = new \Sql\QueryBuilder($environment, $query);

        $sql = $q->table('products')
            ->eq('name', 'Chart Radio');

        print_r($sql->run($environment));
        print_r($this->database->prepare($sql->run($environment))->execute(array('name' => 'Chart Radio')));
    }
}