<?php

namespace Jql\Operations;

use Jql\Environment;
use Jql\Query;
use Mockery;
use TestCase;

class QueryBuilderTest extends TestCase
{
    /**
     * @var Query
     */
    private $query_builder;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var Mockery\MockInterface
     */
    private $a;

    /**
     * @var Mockery\MockInterface
     */
    private $b;

    /**
     * @var Mockery\MockInterface
     */
    private $c;

    /**
     * @var Mockery\MockInterface
     */
    private $container;

    public function setUp()
    {
        parent::setUp();

        $this->environment = Mockery::mock('Jql\Environment');
        $this->query_builder = new Query();
        $this->a = Mockery::mock('Jql\Operation');
        $this->b = Mockery::mock('Jql\Operation');
        $this->c = Mockery::mock('Jql\Operation');
        $this->container = Mockery::mock('Jql\OperationContainer');
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
        $operation = $this->query_builder->equal($this->a, $this->b);

        $this->assertInstanceOf('Jql\Operations\EqualOperation', $operation);
        $this->assertEquals($this->a, $operation->a());
        $this->assertEquals($this->b, $operation->b());
    }

    public function testNot()
    {
        $operation = $this->query_builder->not($this->a);

        $this->assertInstanceOf('Jql\Operations\NotOperation', $operation);
        $this->assertEquals($this->a, $operation->value());
    }

    public function testConstant()
    {
        $operation = $this->query_builder->constant($this->a);

        $this->assertInstanceOf('Jql\Operations\ConstantOperation', $operation);
        $this->assertEquals($this->a, $operation->value());
    }

    public function testAnds()
    {
        $operation = $this->query_builder->ands($this->container);

        $this->assertInstanceOf('Jql\Operations\AndOperation', $operation);
        $this->assertEquals($this->container, $operation->values());
    }

    public function testOrs()
    {
        $operation = $this->query_builder->ors($this->container);

        $this->assertInstanceOf('Jql\Operations\OrOperation', $operation);
        $this->assertEquals($this->container, $operation->values());
    }
}
