<?php

namespace Jql;

interface Operation extends Jsonable
{
    /**
     * @return string
     */
    public function op();

    /**
     * @param Environment $environment
     * @return mixed
     */
    public function run(Environment $environment);
}