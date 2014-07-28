<?php

class Query
{
    private $entities = array();
    private $froms = array();
    private $ors = array();
    private $ands = array();

    public function __construct(Environment $env, TermAssembler $terms)
    {
        $this->env = $env;
        $this->terms = $terms;
    }

    /**
     * @param $entity
     * @return $this
     */
    public function select($entity)
    {
        $this->entities[] = $this->terms->entity($entity);

        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function from($table)
    {
        $this->froms[] = $this->terms->from($this->terms->table($table));

        return $this;
    }

    /**
     * @param $table
     * @param $on
     * @param $to
     * @return $this
     */
    public function join($table, $on, $to)
    {
        $this->froms[] = $this->terms->leftJoin($this->terms->table($table), $this->terms->eq($this->terms->field($on), $this->terms->field($to)));

        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @return $this
     */
    public function where($field, $value)
    {
        $this->ands[] = $this->terms->eq($this->terms->field($field), $this->terms->param($value));

        return $this;
    }

    public function orWhere(callable $callback)
    {
        $this->ors[] = $this->ands;

        $qb = new Query($this->env, $this->terms);
        $callback($qb);
        $q = $qb->build();

        $this->ors[] = $this->env->get($this->env->get($q, 'w'), 'v');
        $this->ands = array();

        return $this;
    }

    public function build()
    {
        $me = $this;
        $where = null;

        if (count($this->ands)) {
            $this->ors[] = $this->ands;
        }

        if (count($this->ors)) {
            $where = $this->terms->ors(array_map(function ($ands) use ($me) {
                return $me->terms->ands($ands);
            }, $this->ors));
        }

        return $this->terms->select(
            $this->entities,
            $this->froms,
            $where
        );
    }

    public function get()
    {
        var_dump($this->env->run($this->build()));

        return $this->env->execute($this->build());
    }
}