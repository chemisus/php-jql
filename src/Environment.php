<?php

interface Environment extends TermReader
{
    /**
     * @param $term
     * @return Term
     */
    public function term($term);

    /**
     * @param $term
     * @return mixed
     */
    public function run($term);

    /**
     * @param $term
     * @return boolean
     */
    public function verify($term);

    /**
     * @param $query
     * @return mixed[]
     */
    public function execute($query);
}