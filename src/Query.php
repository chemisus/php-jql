<?php

class Query
{
    private $entities = array();
    private $froms = array();
    private $ors = array();
    private $ands = array();
    private $reader;

    public function __construct(TermReader $reader, TermAssembler $terms)
    {
        $this->reader = $reader;
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
     * @param string|null $alias
     * @return $this
     */
    public function from($table, $alias = null)
    {
        $from = $this->terms->table($table);

        if ($alias !== null) {
            $from = $this->terms->alias($from, $alias);
        }

        $this->froms[] = $this->terms->from($from);

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

        $qb = new Query($this->reader, $this->terms);
        $callback($qb);
        $q = $qb->build();

        $this->ors[] = $this->reader->get($this->reader->get($q, 'w'), 'v');
        $this->ands = array();

        return $this;
    }

    public function find($values)
    {
        foreach ($values as $key => $value) {
            $this->where($key, $value);
        }

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
}