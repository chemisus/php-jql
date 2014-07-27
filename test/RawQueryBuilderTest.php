<?php

class RawQueryBuilderTest extends TestCase
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testEqualTrue(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testEqualFalse(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testNotTrue(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testNotFalse(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testAndTrue(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testAndFalse(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testOrTrue(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testOrFalse(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectFromUsers(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select * from "users"';
        $jql = array(
            array('id' => 1, 'name' => 'terrence'),
            array('id' => 2, 'name' => 'jessica'),
            array('id' => 3, 'name' => 'nick'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->from($q->table('users')))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectFromUsersLikes(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $this->markTestSkipped('something weird happens with likes. maybe a foreign key thing?');

        $sql = 'select' .
            ' "users"."id",' .
            ' "users"."name",' .
            ' "likes"."id" as "like_id",' .
            ' "likes"."user_id",' .
            ' "likes"."book_id"' .
            ' from "users", "likes"';
        $jql = array(
            array('id' => 1, 'name' => "terrence", 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 2, 'name' => "jessica", 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 3, 'name' => "nick", 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 1, 'name' => "terrence", 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
        );

        $query = $q->select(
            array(
                $q->entity('users.id'),
                $q->entity('users.name'),
                $q->alias($q->entity('likes.id'), 'like_id'),
                $q->entity('likes.user_id'),
                $q->entity('likes.book_id'),
            ),
            array($q->from($q->table('users'), $q->table('likes')))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectFromUsersLeftJoinLikesLeftJoinBooks(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select' .
            ' "users"."id",' .
            ' "users"."name",' .
            ' "books"."id" as "book",' .
            ' "books"."title",' .
            ' "books"."author_id",' .
            ' "likes"."id" as "like_id",' .
            ' "likes"."user_id",' .
            ' "likes"."book_id"' .
            ' from "users" left join "books" on true left join "likes" on true';
        $jql = array(
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
        );

        $query = $q->select(
            array(
                $q->entity('users.id'),
                $q->entity('users.name'),
                $q->alias($q->entity('books.id'), 'book'),
                $q->entity('books.title'),
                $q->entity('books.author_id'),
                $q->alias($q->entity('likes.id'), 'like_id'),
                $q->entity('likes.user_id'),
                $q->entity('likes.book_id'),
            ),
            array(
                $q->from($q->table('users')),
                $q->leftJoin($q->table('books'), $q->true()),
                $q->leftJoin($q->table('likes'), $q->true())
            )
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectFromUsersCrossJoinLikesCrossJoinBooks(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select' .
            ' "users"."id",' .
            ' "users"."name",' .
            ' "books"."id" as "book",' .
            ' "books"."title",' .
            ' "books"."author_id",' .
            ' "likes"."id" as "like_id",' .
            ' "likes"."user_id",' .
            ' "likes"."book_id"' .
            ' from "users" cross join "books" cross join "likes"';
        $jql = array(
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 1, 'name' => "terrence", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 2, 'name' => "jessica", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 1, 'title' => "C++", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 2, 'title' => "Java", 'author_id' => 1, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 1, 'user_id' => 1, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 2, 'user_id' => 1, 'book_id' => 3),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 3, 'user_id' => 2, 'book_id' => 1),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 4, 'user_id' => 2, 'book_id' => 2),
            array('id' => 3, 'name' => "nick", 'book' => 3, 'title' => "PHP", 'author_id' => 2, 'like_id' => 5, 'user_id' => 3, 'book_id' => 2),
        );

        $query = $q->select(
            array(
                $q->entity('users.id'),
                $q->entity('users.name'),
                $q->alias($q->entity('books.id'), 'book'),
                $q->entity('books.title'),
                $q->entity('books.author_id'),
                $q->alias($q->entity('likes.id'), 'like_id'),
                $q->entity('likes.user_id'),
                $q->entity('likes.book_id'),
            ),
            array(
                $q->from($q->table('users')),
                $q->crossJoin($q->table('books')),
                $q->crossJoin($q->table('likes'))
            )
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectAllFromUsers(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select * from "users"';
        $jql = array(
            array('id' => 1, 'name' => 'terrence'),
            array('id' => 2, 'name' => 'jessica'),
            array('id' => 3, 'name' => 'nick'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->from($q->table('users')))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectIdFromUsers(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select "users"."id" from "users"';
        $jql = array(
            array('id' => 1),
            array('id' => 2),
            array('id' => 3),
        );

        $query = $q->select(
            array($q->entity('users.id')),
            array($q->from($q->table('users')))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectAllFromUsersWhereIdIs1(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select * from "users" where "users"."id"=?';
        $jql = array(
            array('id' => 1, 'name' => 'terrence'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->from($q->table('users'))),
            $q->eq($q->field("users.id"), $q->param(1))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals(array(1), $sql_env->parameters());
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testExecute(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select * from "users" where "users"."id"=?';

        $query = $q->select(
            array($q->entity('*')),
            array($q->from($q->table('users'))),
            $q->eq($q->field("users.id"), $q->param(1))
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testOrs(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select * from "users" where ("users"."id"=?) or ("users"."id"=?)';

        $query = $q->select(
            array($q->entity('*')),
            array($q->from($q->table('users'))),
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
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testLimitAndOffset(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select * from "users" where ("users"."id"=?) or ("users"."id"=?) limit ? offset ?';
        $jql = array(
            array('id' => 2, 'name' => 'jessica'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->from($q->table('users'))),
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

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testAlias(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select "users"."id" as "id_alias" from "users" where ("users"."id"=?) or ("users"."id"=?) limit ? offset ?';
        $jql = array(
            array('id_alias' => 2),
        );

        $query = $q->select(
            array($q->alias($q->entity('users.id'), 'id_alias')),
            array($q->from($q->table('users'))),
            $q->ors(array(
                $q->eq($q->field('users.id'), $q->param(1)),
                $q->eq($q->field('users.id'), $q->param(2))
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

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testGreaterThan(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select * from "users" where "users"."id">?';
        $jql = array(
            array('id' => 2, 'name' => 'jessica'),
            array('id' => 3, 'name' => 'nick'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->from($q->table('users'))),
            $q->gt($q->field('users.id'), $q->param(1))
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->execute($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testLesserThan(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select * from "users" where "users"."id"<?';
        $jql = array(
            array('id' => 1, 'name' => 'terrence'),
            array('id' => 2, 'name' => 'jessica'),
        );

        $query = $q->select(
            array($q->entity('*')),
            array($q->from($q->table('users'))),
            $q->lt($q->field('users.id'), $q->param(3))
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->execute($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSubQuery(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select "t"."id", "t"."name" from (select * from "users" where "users"."id">?) as "t" where "t"."id"<?';
        $jql = array(
            array('id' => 2, 'name' => 'jessica'),
        );

        $query = $q->select(
            array(
                $q->entity('t.id'),
                $q->entity('t.name'),
            ),
            array(
                $q->from($q->subquery(
                    $q->select(
                        array($q->entity('*')),
                        array($q->from($q->table('users'))),
                        $q->gt($q->field("users.id"), $q->param(1))
                    ),
                    't'
                ))
            ),
            $q->lt($q->field("t.id"), $q->param(3))
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->execute($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectEntity(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select "id", "name" from "users"';
        $jql = array(
            array('id' => 1, 'name' => 'terrence'),
            array('id' => 2, 'name' => 'jessica'),
            array('id' => 3, 'name' => 'nick'),
        );

        $query = $q->select(
            array(
                $q->entity('id'),
                $q->entity('name')
            ),
            array($q->from($q->table('users')))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testSelectField(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select "id", "name" from "users" where "id"=?';
        $jql = array(
            array('id' => 2, 'name' => 'jessica'),
        );

        $query = $q->select(
            array(
                $q->entity('id'),
                $q->entity('name')
            ),
            array($q->from($q->table('users'))),
            $q->eq($q->field('id'), $q->param(2))
        );

        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testLeftJoin(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select "users"."id", "users"."name", "books"."title" from "users" left join "books" as "books" on "books"."author_id"="users"."id"';
        $jql = array(
            array('id' => 1, 'name' => "terrence", 'title' => "C++"),
            array('id' => 1, 'name' => "terrence", 'title' => "Java"),
            array('id' => 2, 'name' => "jessica", 'title' => "PHP"),
            array('id' => 3, 'name' => "nick", 'title' => null),

        );

        $query = $q->select(
            array(
                $q->entity('users.id'),
                $q->entity('users.name'),
                $q->entity('books.title'),
            ),
            array(
                $q->from($q->table('users')),
                $q->leftJoin(
                    $q->alias($q->table('books'), 'books'),
                    $q->eq(
                        $q->field('books.author_id'),
                        $q->field('users.id')
                    )
                )
            )
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }

    /**
     * @param Environment $sql_env
     * @param Environment $jql_env
     * @param RawQueryBuilder $q
     * @dataProvider queryBuilderProvider
     */
    public function testRightJoin(Environment $sql_env, Environment $jql_env, RawQueryBuilder $q)
    {
        $sql = 'select "users"."id", "users"."name", "books"."title" from "users" right join "books" as "books" on "books"."author_id"="users"."id"';
        $jql = array(
            array('id' => 1, 'name' => "terrence", 'title' => "C++"),
            array('id' => 1, 'name' => "terrence", 'title' => "Java"),
            array('id' => 2, 'name' => "jessica", 'title' => "PHP"),
        );

        $query = $q->select(
            array(
                $q->entity('users.id'),
                $q->entity('users.name'),
                $q->entity('books.title'),
            ),
            array(
                $q->from($q->table('users')),
                $q->rightJoin(
                    $q->alias($q->table('books'), 'books'),
                    $q->eq(
                        $q->field('books.author_id'),
                        $q->field('users.id')
                    )
                )
            )
        );

        $this->assertEquals($sql, $sql_env->run($query));
        $this->assertEquals($jql, $jql_env->run($query));
        $this->assertEquals($sql_env->execute($query), $jql_env->execute($query));
    }
}
