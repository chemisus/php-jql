<?php

namespace Sql\Operations;

use Sql\AbstractOperation;
use Sql\Environment;
use Sql\Operation;

class TableOperation extends AbstractOperation
{
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct('table');

        $this->name = $name;
    }

    /**
     * @param Environment $environment
     * @return mixed
     */
    public function run(Environment $environment)
    {
        return $environment->table($this->name);
    }
}