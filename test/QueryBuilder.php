<?php

class QueryBuilder extends TestCase
{
    public function queryBuilderProvider()
    {
        $sdb = new PDO("pgsql:dbname=users_books;host=localhost", "homestead", "secret");

        $jdb = array(
            'users' => array(
                array('id' => 1, 'name' => 'terrence'),
                array('id' => 2, 'name' => 'jessica'),
                array('id' => 3, 'name' => 'nick'),
            ),
            'likes' => array(
                array('id' => 1, 'user_id' => 1, 'book_id' => 1),
                array('id' => 2, 'user_id' => 1, 'book_id' => 3),
                array('id' => 3, 'user_id' => 2, 'book_id' => 1),
                array('id' => 4, 'user_id' => 2, 'book_id' => 2),
                array('id' => 5, 'user_id' => 3, 'book_id' => 2),
            ),
            'books' => array(
                array('id' => 1, 'title' => 'C++', 'author_id' => 1),
                array('id' => 2, 'title' => 'Java', 'author_id' => 1),
                array('id' => 3, 'title' => 'PHP', 'author_id' => 2),
            ),
        );

        $otb = new ObjectTermBuilder();
        $atb = new ArrayTermBuilder();

        $oqb = new RawQueryBuilder($otb);
        $aqb = new RawQueryBuilder($atb);

        $oqb = new RawQueryBuilder($otb);
        $aqb = new RawQueryBuilder($atb);

        $sql_o = new Sql\SqlEnvironment($otb, $sdb);
        $jql_o = new Jql\JqlEnvironment($otb, $jdb);

        $sql_a = new Sql\SqlEnvironment($atb, $sdb);
        $jql_a = new Jql\JqlEnvironment($atb, $jdb);

        return array(
            array($jql_a, $aqb),
            array($sql_a, $aqb),
            array($jql_o, $oqb),
            array($sql_o, $oqb),
        );
    }

//    public function test(Environment $env, QueryBuilder $qb)
//    {
//        $this->markTestSkipped();
//
//        $q = new Query($env, $qb);
//    }
}