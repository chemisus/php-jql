<?php

namespace Sql;

use AbstractEnvironment;
use PDO;

class SqlEnvironment extends AbstractEnvironment
{
    /**
     * @var PDO
     */
    private $pdo;

    private $parameters = array();

    public function __construct(PDO $pdo)
    {
        parent::__construct(array(
            new SqlTrueTerm(),
            new SqlFalseTerm(),
            new SqlEqualOperation(),
            new SqlNotOperation(),
            new SqlAndOperation(),
            new SqlOrOperation(),
            new SqlSelectOperation(),
            new SqlTableOperation(),
            new SqlEntityOperation(),
            new SqlParameterOperation(),
            new SqlFieldOperation(),
        ));

        $this->pdo = $pdo;
    }

    public function parameters()
    {
        return $this->parameters;
    }

    public function parameter($value)
    {
        $this->parameters[] = $value;
    }
}