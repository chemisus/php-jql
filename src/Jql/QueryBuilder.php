<?php

namespace Jql;

use Jql\Operations\AndOperation;
use Jql\Operations\OrOperation;

class QueryBuilder
{
    private $environment;
    private $from;
    private $container;
    private $query;
    private $where;

    public function __construct(Environment $environment, Query $query)
    {
        $this->environment = $environment;
        $this->query = $query;
        $this->container = new OperationContainer(array());
        $this->where = new AndOperation($this->container);
    }

    /**
     * @param $name
     * @return $this
     */
    public function table($name)
    {
        $this->from = $this->query->table($name);

        return $this;
    }

    /**
     * @param $a
     * @param $b
     * @return $this
     */
    public function eq($a, $b)
    {
        $this->container->add($this->query->equal(
            $this->query->select($this->query->constant($a)),
            $this->query->constant($b)
        ));

        return $this;
    }

    public function orWhere(callable $callback)
    {
        $builder = new QueryBuilder($this->environment, $this->query);

        call_user_func($callback, $builder);

        return $this;
    }

    public function where()
    {
        return $this->where;
    }

    /**
     * @return $this
     */
    public function exec()
    {
        return $this->query->filter(
            $this->from,
            $this->where
        )->run($this->environment);
    }
}