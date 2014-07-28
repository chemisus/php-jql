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
            array(new QueryBuilder($sql_o, $oqb)),
            array(new QueryBuilder($jql_o, $oqb)),
            array(new QueryBuilder($sql_a, $aqb)),
            array(new QueryBuilder($jql_a, $aqb)),
        );
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testSelectIdFromUsers(QueryBuilder $qb)
    {
        $expect = array(
            array('id' => 1),
            array('id' => 2),
            array('id' => 3),
        );

        $actual = $qb->query()
            ->select('id')
            ->from('users')
            ->get();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testSelectIdAndAuthorFromBooks(QueryBuilder $qb)
    {
        $expect = array(
            array('id' => 1, 'author_id' => 1),
            array('id' => 2, 'author_id' => 1),
            array('id' => 3, 'author_id' => 2),
        );

        $actual = $qb->query()
            ->select('id')
            ->select('author_id')
            ->from('books')
            ->get();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testSelectIdAndAuthorFromBooksLeftJoinUser(QueryBuilder $qb)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'C++',),
            array('name' => 'terrence', 'title' => 'Java',),
            array('name' => 'jessica', 'title' => 'PHP',),
        );

        $actual = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->get();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereName(QueryBuilder $qb)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'C++',),
            array('name' => 'terrence', 'title' => 'Java',),
        );

        $actual = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->where('name', 'terrence')
            ->get();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereNameAndTitle(QueryBuilder $qb)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'C++',),
        );

        $actual = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->where('name', 'terrence')
            ->where('title', 'C++')
            ->get();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereNameAndTitleJava(QueryBuilder $qb)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'Java',),
        );

        $actual = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->where('name', 'terrence')
            ->where('title', 'Java')
            ->get();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereNameNickOrTitleJava(QueryBuilder $qb)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'Java',),
        );

        $actual = $qb->query()
            ->select('name')
            ->select('title')
            ->from('books')
            ->join('users', 'users.id', 'author_id')
            ->where('name', 'nick')
            ->orWhere(function ($query) {
                $query->where('title', 'Java');
            })
            ->get();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testWhereTitleJavaOrNameNick(QueryBuilder $qb)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'Java',),
            array('name' => 'nick', 'title' => null),
        );

        $actual = $qb->query()
            ->select('name')
            ->select('title')
            ->from('users')
            ->join('books', 'books.author_id', 'users.id')
            ->where('name', 'nick')
            ->orWhere(function ($query) {
                $query->where('title', 'Java');
            })
            ->get();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @param QueryBuilder $qb
     * @dataProvider queryBuilderProvider
     */
    public function testFields(QueryBuilder $qb)
    {
        $expect = array(
            array('name' => 'terrence', 'title' => 'Java',),
        );

        $actual = $qb->query()
            ->select('name')
            ->select('title')
            ->from('users')
            ->join('books', 'books.author_id', 'users.id')
            ->fields(array(
                'name' => 'terrence',
                'title' => 'Java',
            ))
            ->get();

        $this->assertEquals($expect, $actual);
    }
}