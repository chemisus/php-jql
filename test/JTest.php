<?php

class JTest extends TestCase
{
    public function testMap()
    {
        $query = new \Jql\Query();
        $environment = new \Jql\Environment();

        $rows = array(
            array('name' => 'a', 'password' => 'A'),
            array('name' => 'b', 'password' => 'B'),
            array('name' => 'c', 'password' => 'C'),
        );

        $jql = $query->map(
            $query->constant($rows),
            $query->object(new \Jql\OperationContainer(array(
                'name_test' => $query->select($query->constant('name')),
                'password_test' => $query->select($query->constant('password')),
            )))
        );

        print_r($jql->run($environment));
        print_r($jql->toJson());
    }

    public function testReduce()
    {
        $query = new \Jql\Query();
        $environment = new \Jql\Environment();

        $rows = array(
            1,
            2,
            3,
        );

        $jql = $query->reduce(
            $query->constant($rows),
            $query->constant(5),
            $query->add()
        );

        var_dump($jql->run($environment));
        var_dump($jql->toJson());
    }

    public function testFilter()
    {
        $query = new \Jql\Query();
        $environment = new \Jql\Environment();

        $rows = array(
            array('name' => 'a', 'password' => 'A'),
            array('name' => 'b', 'password' => 'B'),
            array('name' => 'c', 'password' => 'C'),
        );

        $jql = $query->filter(
            $query->constant($rows),
            $query->ors(new \Jql\OperationContainer(array(
                $query->equal(
                    $query->select($query->constant('name')),
                    $query->constant('b')
                ),
                $query->equal(
                    $query->select($query->constant('password')),
                    $query->constant('C')
                ),
            )))
        );

        print_r($jql->run($environment));
        print_r($jql->toJson());
    }

    public function testQueryBuilder()
    {
        $database = new \Jql\Database(array(
            'users' => array(
                array('name' => 'Terrence'),
                array('name' => 'Jessica'),
                array('name' => 'Mike'),
            )
        ));

        $environment = new \Jql\Environment($database);

        $q = new \Jql\QueryBuilder($environment, new \Jql\Query());

        $results = $q->table('users')
            ->eq('name', 'Terrence')
            ->orWhere(function (\Jql\QueryBuilder $query) {
                $query->eq('name', 'Jessica');
            })

            ->exec();

        var_dump($results);
    }
}