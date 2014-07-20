<?php

namespace Jql;

interface Method
{
    public function call(Environment $environment, $value);
}
