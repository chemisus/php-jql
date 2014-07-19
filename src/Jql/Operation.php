<?php

namespace Jql;

interface Operation
{
    public function run(Environment $environment, \stdClass $operation);
}