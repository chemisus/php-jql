<?php

class QueryTest extends TestCase
{
    /**
     * @var Environment
     */
    private $sql;

    /**
     * @var Environment
     */
    private $jql;

    public function setUp()
    {
        $sdb = new PDO("pgsql:dbname=users_books;host=localhost", "homestead", "secret");

        $jdb = array(
            'users' => array(
                array('id' => 1, 'name' => 'terrence'),
                array('id' => 2, 'name' => 'jessica'),
                array('id' => 3, 'name' => 'mike'),
            ),
            'likes' => array(
                array('id' => 1, 'user_id' => 1, 'book_id' => 3),
                array('id' => 2, 'user_id' => 1, 'book_id' => 3),
                array('id' => 3, 'user_id' => 2, 'book_id' => 3),
                array('id' => 4, 'user_id' => 2, 'book_id' => 3),
                array('id' => 5, 'user_id' => 3, 'book_id' => 3),
            ),
            'books' => array(
                array('id' => 1, 'name' => 'C++', 'author_id' => 1),
                array('id' => 2, 'name' => 'Java', 'author_id' => 1),
                array('id' => 3, 'name' => 'PHP', 'author_id' => 2),
            ),
        );

        $this->sql = new Sql\SqlEnvironment($sdb);
        $this->jql = new Jql\JqlEnvironment($jdb);
    }

    public function testEqualTrue()
    {
        $q = new QueryBuilder();

        $sql = 'true=true';
        $jql = true;

        $query = $q->eq(
            $q->true(),
            $q->true()
        );

        $this->assertEquals($sql, $this->sql->run($query));
        $this->assertEquals($jql, $this->jql->run($query));
    }

    public function testEqualFalse()
    {
        $q = new QueryBuilder();

        $sql = 'true=false';
        $jql = false;

        $query = $q->eq(
            $q->true(),
            $q->false()
        );

        $this->assertEquals($sql, $this->sql->run($query));
        $this->assertEquals($jql, $this->jql->run($query));
    }

    public function testNotTrue()
    {
        $q = new QueryBuilder();

        $sql = 'not true';
        $jql = false;

        $query = $q->not($q->true());

        $this->assertEquals($sql, $this->sql->run($query));
        $this->assertEquals($jql, $this->jql->run($query));
    }

    public function testNotFalse()
    {
        $q = new QueryBuilder();

        $sql = 'not false';
        $jql = true;

        $query = $q->not($q->false());

        $this->assertEquals($sql, $this->sql->run($query));
        $this->assertEquals($jql, $this->jql->run($query));
    }

    public function testAndTrue()
    {
        $q = new QueryBuilder();

        $sql = 'true and true and true';
        $jql = true;

        $query = $q->ands(array(
            $q->true(),
            $q->true(),
            $q->true(),
        ));

        $this->assertEquals($sql, $this->sql->run($query));
        $this->assertEquals($jql, $this->jql->run($query));
    }

    public function testAndFalse()
    {
        $q = new QueryBuilder();

        $sql = 'true and false and true';
        $jql = false;

        $query = $q->ands(array(
            $q->true(),
            $q->false(),
            $q->true(),
        ));

        $this->assertEquals($sql, $this->sql->run($query));
        $this->assertEquals($jql, $this->jql->run($query));
    }

    public function testOrTrue()
    {
        $q = new QueryBuilder();

        $sql = '(true) or (false) or (false)';
        $jql = true;

        $query = $q->ors(array(
            $q->true(),
            $q->false(),
            $q->false(),
        ));

        $this->assertEquals($sql, $this->sql->run($query));
        $this->assertEquals($jql, $this->jql->run($query));
    }

    public function testOrFalse()
    {
        $q = new QueryBuilder();

        $sql = '(false) or (false) or (false)';
        $jql = false;

        $query = $q->ors(array(
            $q->false(),
            $q->false(),
            $q->false(),
        ));

        $this->assertEquals($sql, $this->sql->run($query));
        $this->assertEquals($jql, $this->jql->run($query));
    }

    public function testSelect()
    {
        $q = new QueryBuilder();

        $sql = 'select * from "users"';
        $jql = array(
            array('users.id' => 1, 'users.name' => 'terrence'),
            array('users.id' => 2, 'users.name' => 'jessica'),
            array('users.id' => 3, 'users.name' => 'mike'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->table('users'))
        );

        $this->assertEquals($jql, $this->jql->run($query));
        $this->assertEquals($sql, $this->sql->run($query));
    }

}
