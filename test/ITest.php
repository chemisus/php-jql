<?php

class ITest extends TestCase
{
    public function testA()
    {
        $q = new \Jql\QueryBuilder();
        $environment = new \Jql\Environment();

        $rows = array(
            array('name' => 'a', 'password' => 'A'),
            array('name' => 'b', 'password' => 'B'),
            array('name' => 'c', 'password' => 'C'),
        );

        $jql = $q->map(
            $q->constant($rows),
            $q->object(new \Jql\OperationContainer(array(
                'name_test' => $q->select($q->constant('name')),
                'password_test' => $q->select($q->constant('password')),
            )))
        );

        print_r($jql->run($environment));
        print_r($jql->toJson());
    }
}