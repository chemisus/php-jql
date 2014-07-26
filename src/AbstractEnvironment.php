<?php

abstract class AbstractEnvironment implements Environment
{
    private $terms;
    private $term_reader;

    /**
     * @param TermReader $term_reader
     * @param Term[] $terms
     */
    public function __construct(TermReader $term_reader, $terms = array())
    {
        $this->term_reader = $term_reader;

        foreach ($terms as $term) {
            $this->terms[$term->name()] = $term;
        }
    }

    /**
     * @param $term
     * @return string
     */
    public function name($term)
    {
        return $this->term_reader->name($term);
    }

    /**
     * @param $term
     * @return Term
     */
    public function term($term)
    {
        return $this->terms[$this->name($term)];
    }

    /**
     * @param $term
     * @param $key
     * @return bool
     */
    public function has($term, $key)
    {
        return $this->term_reader->has($term, $key);
    }

    /**
     * @param $term
     * @param $key
     * @return mixed
     */
    public function get($term, $key)
    {
        return $this->term_reader->get($term, $key);
    }

    /**
     * @param $term
     * @return bool
     */
    public function verify($term)
    {
        return $this->term($term)->verify($this, $term);
    }

    /**
     * @param $term
     * @return mixed
     * @throws Exception
     */
    public function run($term)
    {
        if (!$this->verify($term)) {
            throw new Exception(' verification failed');
        }

        return $this->term($term)->run($this, $term);
    }
}