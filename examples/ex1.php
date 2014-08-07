<?php

namespace Example1;

require_once dirname(__DIR__) . '/vendor/autoload.php';

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

echo json_encode($jdb);

$sdb = new \PDO("pgsql:dbname=users_books;host=localhost", "homestead", "secret");

$atb = new \ArrayTermBuilder();
$terms = new \TermAssembler($atb);
$q = new \QueryBuilder($atb, $terms);
$jql = new \Jql\JqlEnvironment($atb, $jdb);
$sql = new \Sql\SqlEnvironment($atb, $sdb);

$query = $q->query()
    ->select('name')
    ->select('title')
    ->from('users')
    ->join('books', 'books.author_id', 'users.id')
    ->find(array(
        'name' => 'terrence',
        'title' => 'Java',
    ))
;

$n = 4000;
$built = $query->build();

$bench_jql = new \Ubench();
$bench_jql->start();
for ($i = 0; $i < $n; $i++) {
    $jql_result = $jql->execute($built);
}
$bench_jql->end();

var_dump($jql_result);

$bench_sql = new \Ubench();
$bench_sql->start();
for ($i = 0; $i < $n; $i++) {
    $sql_result = $sql->execute($built);
}
$bench_sql->end();

var_dump($sql_result);
var_dump($bench_sql->getTime(), $bench_sql->getMemoryUsage());
var_dump($bench_jql->getTime(), $bench_jql->getMemoryUsage());
