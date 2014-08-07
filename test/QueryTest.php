<?php

class QueryTest extends TestCase
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

        $oqb = new TermAssembler($otb);
        $aqb = new TermAssembler($atb);

        $sql_o = new Sql\SqlEnvironment($otb, $sdb);
        $jql_o = new Jql\JqlEnvironment($otb, $jdb);

        $sql_a = new Sql\SqlEnvironment($atb, $sdb);
        $jql_a = new Jql\JqlEnvironment($atb, $jdb);

        return array(
            array(new QueryBuilder($otb, $oqb), $sql_o),
            array(new QueryBuilder($otb, $oqb), $jql_o),
            array(new QueryBuilder($atb, $aqb), $sql_a),
            array(new QueryBuilder($atb, $aqb), $jql_a),
        );
    }

    /**
     * @param QueryBuilder $qb
     * @param Environment $env
     * @dataProvider queryBuilderProvider
     */
    public function testSelectIdFromUsers(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('id' => 1),
            array('id' => 2),
            array('id' => 3),
        );

        $query = $qb->query()
            ->select('id')
            ->from('users');

        $this->assertEquals($expect, $env->execute($query->build()));
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testSelectIdAndAuthorFromBooks(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('id' => 1, 'author_id' => 1),
            array('id' => 2, 'author_id' => 1),
            array('id' => 3, 'author_id' => 2),
        );

        $query = $qb->query()
            ->select('id')
            ->select('author_id')
            ->from('books');

        $this->assertEquals($expect, $env->execute($query->build()));
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testSelectIdAndAuthorFromBooksLeftJoinUser(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'C++',),
            array('name' => 'terrence', 'title' => 'Java',),
            array('name' => 'jessica', 'title' => 'PHP',),
        );

        $query = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id');

        $this->assertEquals($expect, $env->execute($query->build()));
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereName(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'C++',),
            array('name' => 'terrence', 'title' => 'Java',),
        );

        $query = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->where('name', 'terrence');

        $this->assertEquals($expect, $env->execute($query->build()));
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereNameAndTitle(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'C++',),
        );

        $query = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->where('name', 'terrence')
            ->where('title', 'C++');

        $this->assertEquals($expect, $env->execute($query->build()));
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereNameAndTitleJava(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'Java',),
        );

        $query = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->where('name', 'terrence')
            ->where('title', 'Java');

        $this->assertEquals($expect, $env->execute($query->build()));
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereNameNickOrTitleJava(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'Java',),
        );

        $query = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->where('name', 'nick')
            ->orWhere(function ($query) {
                $query->where('title', 'Java');
            });

        $this->assertEquals($expect, $env->execute($query->build()));
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereTitleJavaOrNameNick(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'Java',),
            array('name' => 'nick', 'title' => null),
        );

        $query = $qb->query()
            ->select('name')
            ->select('title')
            ->from('users')
            ->join('books', 'books.author_id', 'users.id')
            ->where('name', 'nick')
            ->orWhere(function ($query) {
                $query->where('title', 'Java');
            });

        $this->assertEquals($expect, $env->execute($query->build()));
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testFind(QueryBuilder $qb, Environment $env)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'Java',),
        );

        $query = $qb->query()
            ->select('name')
            ->select('title')
            ->from('users')
            ->join('books', 'books.author_id', 'users.id')
            ->find(array(
                'name' => 'terrence',
                'title' => 'Java',
            ));

        $this->assertEquals($expect, $env->execute($query->build()));
    }
}