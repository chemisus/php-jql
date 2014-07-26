<?php

interface TermFactory
{
    public function makeEqual(Term $a, Term $b);

    public function makeAnd($terms = array());

    public function makeOr($terms = array());

    public function makePath($terms = array());

    public function makeParameter($name);
}
