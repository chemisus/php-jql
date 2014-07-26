<?php

class TermQueryBuilder implements Term
{
    private $term_factory;
    private $or;
    private $and;

    public function __construct(TermFactory $term_factory)
    {
        $this->term_factory = $term_factory;
        $this->or = $this->term_factory->makeOr();
        $this->push();
    }

    public function push()
    {
        $this->and = $this->term_factory->makeAnd();
        $this->or->add($this->and);
    }

    public function where(Term $term)
    {
        $this->and->add($term);

        return $this;
    }

    public function orWhere(callable $callback)
    {
        $this->push();

        call_user_func($callback, $this);

        return $this;
    }

    public function orWheres($callbacks)
    {
        foreach ((array)$callbacks as $callback) {
            $this->orWhere($callback);
        }

        return $this;
    }

    public function path($path)
    {
        return $this->term_factory->makePath($path);
    }

    public function param($name)
    {
        return $this->term_factory->makeParameter($name);
    }

    public function eq(Term $a, Term $b)
    {
        return $this->where(new SqlEqualOperation($a, $b));
    }

    public function toSql()
    {
        return $this->or->toSql();
    }
}