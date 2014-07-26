<?php

class RelationFactory
{
    private $has_many;

    public function __construct(HasMany $has_many)
    {
        $this->has_many = $has_many;
    }

    /**
     * @param $from
     * @param $to
     * @param $fields
     * @return HasMany
     */
    public function hasMany($from, $to, $fields)
    {
        return $this->has_many->apply($from, $to, $fields);
    }
}