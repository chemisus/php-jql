<?php

interface Environment
{
    public function term(stdClass $value);

    public function run(stdClass $value);

    public function verify(stdClass $value);

    public function execute(stdClass $query);
}