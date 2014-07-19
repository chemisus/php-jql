<?php

class JqlTest extends PHPUnit_Framework_TestCase
{
    private $operations;
    private $query;

    public function setUp()
    {
        parent::setUp();

        $this->operations = new \Jql\OperationContainer();
        $this->query = new \Jql\QueryBuilder($this->operations);
    }

    public function testTrue()
    {
        $q = $this->query;

        $jql = $q->true();

        $this->assertTrue($q->run($jql));
    }

    public function testFalse()
    {
        $q = $this->query;

        $jql = $q->false();

        $this->assertFalse($q->run($jql));
    }

    public function testEqualTrue()
    {
        $q = $this->query;

        $jql = $q->equal($q->true(), $q->true());

        $this->assertTrue($q->run($jql));
    }

    public function testEqualFalse()
    {
        $q = $this->query;

        $jql = $q->equal($q->false(), $q->true());

        $this->assertFalse($q->run($jql));
    }

    public function testNot()
    {
        $q = $this->query;

        $jql = $q->not($q->false());

        $this->assertTrue($q->run($jql));
    }

    public function testAndTrue()
    {
        $q = $this->query;

        $jql = $q->and(array(
            $q->true(),
            $q->true(),
            $q->true(),
        ));

        $this->assertTrue($q->run($jql));
    }

    public function testAndFalse()
    {
        $q = $this->query;

        $jql = $q->and(array(
            $q->true(),
            $q->true(),
            $q->false(),
        ));

        $this->assertFalse($q->run($jql));
    }

    public function testOrTrue()
    {
        $q = $this->query;

        $jql = $q->or(array(
            $q->false(),
            $q->false(),
            $q->true(),
        ));

        $this->assertTrue($q->run($jql));
    }

    public function testOrFalse()
    {
        $q = $this->query;

        $jql = $q->or(array(
            $q->false(),
            $q->false(),
            $q->false(),
        ));

        $this->assertFalse($q->run($jql));
    }

    public function testConst()
    {
        $q = $this->query;

        $jql = $q->const(true);

        $this->assertTrue($q->run($jql));
    }

    public function testParam()
    {
        $q = $this->query;

        $jql = $q->param('a');

        $this->assertTrue($q->run($jql, array('a' => true)));
    }

    public function testMap()
    {
        $q = $this->query;

        $jql = $q->map('a', $q->const(array('a', 'b', 'c')), $q->true());

        $this->assertCount(3, $q->run($jql));
    }

    public function testGet()
    {
        $q = $this->query;

        $jql = $q->map('v', $q->const(array('a', 'b', 'c')), $q->equal($q->get('v'), $q->const('a')));

        $this->assertCount(1, $q->run($jql));
    }

    public function testGet2()
    {
        $q = $this->query;

        $users = array(
            array('name' => 'terrence'),
            array('name' => 'sue'),
            array('name' => 'mike'),
        );

        $jql = $q->map('user',
            $q->const($users),
            $q->or(array(
                $q->equal($q->get('user.name'), $q->const('terrence')),
                $q->equal($q->get('user.name'), $q->const('mike')),
                $q->equal($q->get('user.name'), $q->const('steve')),
            ))
        );

        $this->assertCount(2, $q->run($jql));
    }
}
