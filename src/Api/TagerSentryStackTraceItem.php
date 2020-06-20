<?php

namespace OZiTAG\Tager\Backend\Sentry\Api;

use Illuminate\Support\ServiceProvider;
use OZiTAG\Tager\Backend\Sentry\Exceptions\TagerSentryApiConfigException;
use OZiTAG\Tager\Backend\Seo\Commands\FlushSeoPagesCommand;

class TagerSentryStackTraceItem
{
    private $file;

    private $function;

    private $line;

    private $col;

    private $codeLines = [];

    public function setFile($value)
    {
        $this->file = $value;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFunction($value)
    {
        $this->function = $value;
    }

    public function getFunction()
    {
        return $this->function;
    }

    public function setLine($value)
    {
        $this->line = $value;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function setCol($value)
    {
        $this->col = $value;
    }

    public function getCol()
    {
        return $this->col;
    }

    public function addCodeLine($line, $code)
    {
        $this->codeLines[$line] = $code;
    }

    public function getCodeLines()
    {
        return $this->codeLines;
    }
}
