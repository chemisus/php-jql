<?php

namespace Sql;

use Sql\Environment;

interface Operation
{
    public function run(Environment $environment);
}