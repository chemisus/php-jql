<?php

class PathTerm implements Term
{
    private $quote;
    private $glue;
    private $names;

    /**
     * @param Container|string[] $names
     * @param string $quote
     * @param string $glue
     */
    public function __construct(Container $names, $quote = '"', $glue = '.')
    {
        $names->verifyContainer('string');

        $this->names = $names;
        $this->glue = $glue;
        $this->quote = $quote;
    }

    public function toSql()
    {
        return $this->names->implode(
            "{$this->quote}{$this->glue}{$this->quote}",
            $this->quote,
            $this->quote,
            $this->names->count()
        );
    }
}