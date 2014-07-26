<?php

namespace Sql;

use AbstractEnvironment;
use PDO;
use TermReader;

class SqlEnvironment extends AbstractEnvironment
{
    /**
     * @var PDO
     */
    private $pdo;

    private $parameters = array();

    public function __construct(TermReader $term_reader, PDO $pdo)
    {
        parent::__construct($term_reader, array(
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
            new SqlAliasOperation(),
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

    public function execute($query)
    {
        $this->parameters = array();

        $statement = $this->pdo->prepare($this->run($query));

        $statement->execute($this->parameters());

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->parameters = array();

        return $rows;
    }
}