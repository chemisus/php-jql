<?php

class SqlTermFactory implements TermFactory
{

    public function makeEqual(Term $a, Term $b)
    {
        return new SqlEqualOperation($a, $b);
    }

    public function makeAnd($terms = array())
    {
        return new TermContainer($terms, ' && ');
    }

    public function makeOr($terms = array())
    {
        return new TermContainer($terms, ') || (', '(', ')');
    }

    public function makePath($entities = array())
    {
        return new PathTerm(new Container($entities));
    }

    public function makeParameter($name)
    {
        return new ParameterTerm($name);
    }
}