<?php

namespace Sql;

interface QueryFactory
{
    public function select();

    public function command();
}
