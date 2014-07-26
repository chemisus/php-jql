<?php

class User
{
    private $table = 'users';

    /**
     * @var HasMany
     */
    private $likes;

    /**
     * @var HasMany
     */
    private $books;

    public function __construct(RelationFactory $relations)
    {
        $this->likes = $relations->hasMany($this->table, 'likes', array('id' => 'user_id'));
        $this->books = $relations->hasMany($this->table, 'books', array('id' => 'author_id'));
    }

    /**
     * @return HasMany
     */
    public function likes()
    {
        return $this->likes;
    }
}