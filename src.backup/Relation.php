<?php

interface Relation
{
    public function make($from, $to, $fields);
}
