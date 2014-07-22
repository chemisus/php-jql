<?php

namespace Sql;

use Sql\Operations\AndOperation;
use Sql\Operations\OrOperation;

class QueryBuilder
{
    private $environment;
    private $from;
    private $and;
    private $query;
    private $where;

    public function __construct(Environment $environment, Query $query)
    {
        $this->environment = $environment;
        $this->query = $query;
        $this->and = new OperationContainer(array());
        $this->or = new OperationContainer(array(new AndOperation($this->and)));
        $this->where = new OrOperation($this->or);
    }

    /**
     * @param $name
     * @return $this
     */
    public function table($name)
    {
        $this->from = $this->query->entity($name);

        return $this;
    }

    /**
     * @param $a
     * @param $b
     * @return $this
     */
    public function eq($a, $b)
    {
        $key = $this->environment->addParameter($b);

        $this->and->add($this->query->equal(
            $this->query->entity($a),
            $this->query->param($key)
        ));

        return $this;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function orWhere(callable $callback)
    {
        $builder = new QueryBuilder($this->environment, $this->query);

        call_user_func($callback, $builder);

        $this->or->add($builder->where());

        $this->and = new OperationContainer(array());
        $this->or->add(new AndOperation($this->and));

        return $this;
    }

    /**
     * @return OrOperation
     */
    public function where()
    {
        return $this->where;
    }

    public function run(Environment $environment)
    {
        return $this->query->select(
            new OperationContainer(array($this->query->entity('*'))),
            $this->from,
            new OperationContainer(array()),
            $this->where
        )->run($environment);
    }
}