<?php

class QueryBuilderTest extends TestCase
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
    }

    public function queryBuilderProvider()
    {
        $sdb = new PDO("pgsql:dbname=users_books;host=localhost", "homestead", "secret");

        $jdb = array(
            'users' => array(
                array('id' => 1, 'name' => 'terrence'),
                array('id' => 2, 'name' => 'jessica'),
                array('id' => 3, 'name' => 'mike'),
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

        $oqb = new QueryBuilder($otb);
        $aqb = new QueryBuilder($atb);

        $sql_o = new Sql\SqlEnvironment($otb, $sdb);
        $jql_o = new Jql\JqlEnvironment($otb, $jdb);

        $sql_a = new Sql\SqlEnvironment($atb, $sdb);
        $jql_a = new Jql\JqlEnvironment($atb, $jdb);

        return array(
            array($sql_a, $jql_a, $aqb),
            array($sql_o, $jql_o, $oqb),
        );
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testEqualTrue(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'true=true';
        $jql = true;

        $query = $q->eq(
            $q->true(),
            $q->true()
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testEqualFalse(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'true=false';
        $jql = false;

        $query = $q->eq(
            $q->true(),
            $q->false()
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testNotTrue(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'not true';
        $jql = false;

        $query = $q->not($q->true());

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testNotFalse(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'not false';
        $jql = true;

        $query = $q->not($q->false());

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testAndTrue(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'true and true and true';
        $jql = true;

        $query = $q->ands(array(
            $q->true(),
            $q->true(),
            $q->true(),
        ));

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testAndFalse(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'true and false and true';
        $jql = false;

        $query = $q->ands(array(
            $q->true(),
            $q->false(),
            $q->true(),
        ));

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testOrTrue(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = '(true) or (false) or (false)';
        $jql = true;

        $query = $q->ors(array(
            $q->true(),
            $q->false(),
            $q->false(),
        ));

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testOrFalse(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = '(false) or (false) or (false)';
        $jql = false;

        $query = $q->ors(array(
            $q->false(),
            $q->false(),
            $q->false(),
        ));

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectFromUsers(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
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

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectFromUsersLikes(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $this->markTestSkipped('something weird happens with likes. maybe a foreign key thing?');

        $sql = 'select * from "users", "likes"';
        $jql = array(
            array('users.id' => 1, 'users.name' => "terrence", 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 2, 'users.name' => "jessica", 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 3, 'users.name' => "mike", 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 1, 'users.name' => "terrence", 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 2, 'users.name' => "jessica", 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 3, 'users.name' => "mike", 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 1, 'users.name' => "terrence", 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 2, 'users.name' => "jessica", 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 3, 'users.name' => "mike", 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 1, 'users.name' => "terrence", 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 2, 'users.name' => "jessica", 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 3, 'users.name' => "mike", 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 1, 'users.name' => "terrence", 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 2, 'users.name' => "jessica", 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 3, 'users.name' => "mike", 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->table('users'), $q->table('likes'))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectFromUsersLikesBooks(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'select * from "users", "books", "likes"';
        $jql = array(
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 1, 'users.name' => "terrence", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 2, 'users.name' => "jessica", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 1, 'books.title' => "C++", 'books.author_id' => 1, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 2, 'books.title' => "Java", 'books.author_id' => 1, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 1, 'likes.user_id' => 1, 'likes.book_id' => 1),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 2, 'likes.user_id' => 1, 'likes.book_id' => 3),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 3, 'likes.user_id' => 2, 'likes.book_id' => 1),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 4, 'likes.user_id' => 2, 'likes.book_id' => 2),
            array('users.id' => 3, 'users.name' => "mike", 'books.id' => 3, 'books.title' => "PHP", 'books.author_id' => 2, 'likes.id' => 5, 'likes.user_id' => 3, 'likes.book_id' => 2),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->table('users'), $q->table('books'), $q->table('likes'))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectAllFromUsers(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
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

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectIdFromUsers(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'select "users"."id" from "users"';
        $jql = array(
            array('users.id' => 1),
            array('users.id' => 2),
            array('users.id' => 3),
        );

        $query = $q->select(
            array($q->entity('users.id')),
            array($q->table('users'))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectAllFromUsersWhereIdIs1(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'select * from "users" where "users"."id"=?';
        $jql = array(
            array('users.id' => 1, 'users.name' => 'terrence'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->table('users')),
            null,
            $q->eq($q->field("users.id"), $q->param(1))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals(array(1), $sql_env->parameters());
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testExecute(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'select * from "users" where "users"."id"=?';

        $query = $q->select(
            array($q->entity('*')),
            array($q->table('users')),
            null,
            $q->eq($q->field("users.id"), $q->param(1))
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testOrs(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'select * from "users" where ("users"."id"=?) or ("users"."id"=?)';

        $query = $q->select(
            array($q->entity('*')),
            array($q->table('users')),
            null,
            $q->ors(array(
                $q->eq($q->field("users.id"), $q->param(1)),
                $q->eq($q->field("users.id"), $q->param(2))
            ))
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param QueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testLimitAndOffset(Environment $sql_env, Environment $jql_env, QueryBuilder $q)
    {
        $sql = 'select * from "users" where ("users"."id"=?) or ("users"."id"=?) limit ? offset ?';
        $jql = array(
            array('id' => 2, 'name' => 'jessica'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->table('users')),
            null,
            $q->ors(array(
                $q->eq($q->field("users.id"), $q->param(1)),
                $q->eq($q->field("users.id"), $q->param(2))
            )),
            null,
            null,
            null,
            $q->param(1),
            $q->param(1)
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->execute($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }
}
