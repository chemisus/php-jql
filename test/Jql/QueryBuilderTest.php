<?php

namespace Jql\Operations;

use Jql\Environment;
use Jql\OperationContainer;
use Jql\QueryBuilder;
use Mockery;
use TestCase;

class QueryBuilderTest extends TestCase
{
    /**
     * @var QueryBuilder
     */
    private $query_builder;

    /**
     * @var Environment
     */
    private $environment;

    public function setUp()
    {
        parent::setUp();

        $this->environment = Mockery::mock('Jql\Environment');
        $this->query_builder = new QueryBuilder();
    }

    public function testTrue()
    {
        $operation = $this->query_builder->true();

        $this->assertInstanceOf('Jql\Operations\TrueOperation', $operation);
    }

    public function testFalse()
    {
        $operation = $this->query_builder->false();

        $this->assertInstanceOf('Jql\Operations\FalseOperation', $operation);
    }

    public function testEqual()
    {
        $lhs = Mockery::mock('Jql\Operation');
        $rhs = Mockery::mock('Jql\Operation');

        $operation = $this->query_builder->equal($lhs, $rhs);

        $this->assertInstanceOf('Jql\Operations\EqualOperation', $operation);
        $this->assertEquals($lhs, $operation->lhs());
        $this->assertEquals($rhs, $operation->rhs());
    }

    public function testNot()
    {
        $value = Mockery::mock('Jql\Operation');

        $operation = $this->query_builder->not($value);

        $this->assertInstanceOf('Jql\Operations\NotOperation', $operation);
        $this->assertEquals($value, $operation->value());
    }

    public function testAnds()
    {
        $values = Mockery::mock('Jql\OperationContainer');

        $operation = $this->query_builder->ands($values);

        $this->assertInstanceOf('Jql\Operations\AndOperation', $operation);
        $this->assertEquals($values, $operation->values());
    }

    public function testOrs()
    {
        $values = Mockery::mock('Jql\OperationContainer');

        $operation = $this->query_builder->ors($values);

        $this->assertInstanceOf('Jql\Operations\OrOperation', $operation);
        $this->assertEquals($values, $operation->values());
    }
}
