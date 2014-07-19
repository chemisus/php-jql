<?php

class JqlTest extends PHPUnit_Framework_TestCase
{
    private $operations;
    private $query_builder;
    private $database;

    public function setUp()
    {
        parent::setUp();

        $tables = array(
            'users' => array(
                array('name' => 'terrence'),
                array('name' => 'sue'),
                array('name' => 'mike'),
            )
        );

        $this->database = new \Jql\Database($tables);
        $this->operations = new \Jql\OperationContainer();
        $this->query_builder = new \Jql\QueryBuilder($this->operations);
    }

    public function testTrue()
    {
        $q = $this->query_builder;

        $jql = $q->true();

        $this->assertTrue($q->run($jql));
    }

    public function testFalse()
    {
        $q = $this->query_builder;

        $jql = $q->false();

        $this->assertFalse($q->run($jql));
    }

    public function testEqualTrue()
    {
        $q = $this->query_builder;

        $jql = $q->equal($q->true(), $q->true());

        $this->assertTrue($q->run($jql));
    }

    public function testEqualFalse()
    {
        $q = $this->query_builder;

        $jql = $q->equal($q->false(), $q->true());

        $this->assertFalse($q->run($jql));
    }

    public function testNot()
    {
        $q = $this->query_builder;

        $jql = $q->not($q->false());

        $this->assertTrue($q->run($jql));
    }

    public function testAndTrue()
    {
        $q = $this->query_builder;

        $jql = $q->and(array(
            $q->true(),
            $q->true(),
            $q->true(),
        ));

        $this->assertTrue($q->run($jql));
    }

    public function testAndFalse()
    {
        $q = $this->query_builder;

        $jql = $q->and(array(
            $q->true(),
            $q->true(),
            $q->false(),
        ));

        $this->assertFalse($q->run($jql));
    }

    public function testOrTrue()
    {
        $q = $this->query_builder;

        $jql = $q->or(array(
            $q->false(),
            $q->false(),
            $q->true(),
        ));

        $this->assertTrue($q->run($jql));
    }

    public function testOrFalse()
    {
        $q = $this->query_builder;

        $jql = $q->or(array(
            $q->false(),
            $q->false(),
            $q->false(),
        ));

        $this->assertFalse($q->run($jql));
    }

    public function testConst()
    {
        $q = $this->query_builder;

        $jql = $q->const(true);

        $this->assertTrue($q->run($jql));
    }

    public function testParam()
    {
        $q = $this->query_builder;

        $jql = $q->param('a');

        $this->assertTrue($q->run($jql, array('a' => true)));
    }

    public function testFilter()
    {
        $q = $this->query_builder;

        $values = array('a', 'b', 'c');

        $jql = $q->filter($q->const($values), $q->true());

        $this->assertCount(3, $q->run($jql));
    }

    public function testCurrent()
    {
        $q = $this->query_builder;

        $values = array('a', 'b', 'c');

        $jql = $q->filter($q->const($values), $q->equal($q->current(), $q->const('a')));

        $this->assertCount(1, $q->run($jql));
    }

    public function testCurrent2()
    {
        $q = $this->query_builder;

        $tables = array(
            array('name' => 'terrence'),
            array('name' => 'sue'),
            array('name' => 'mike'),
        );

        $jql = $q->filter(
            $q->const($tables),
            $q->or(array(
                $q->equal($q->current('name'), $q->const('terrence')),
                $q->equal($q->current('name'), $q->const('mike')),
                $q->equal($q->current('name'), $q->const('steve')),
            ))
        );

        $this->assertCount(2, $q->run($jql));
    }
}
