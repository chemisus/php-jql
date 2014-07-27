<?php

class Query
{
    private $entities = array();
    private $froms = array();

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

    public function join($table, $on, $to)
    {
        $this->froms[] = $this->terms->leftJoin($this->terms->table($table), $this->terms->eq($this->terms->field($on), $this->terms->field($to)));

        return $this;
    }

    public function get()
    {
        return $this->env->execute(
            $this->terms->select(
                $this->entities,
                $this->froms
            )
        );
    }
}