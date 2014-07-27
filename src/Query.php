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