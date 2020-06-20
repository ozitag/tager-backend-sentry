<?php

namespace OZiTAG\Tager\Backend\Sentry\Api;

use Illuminate\Support\ServiceProvider;
use OZiTAG\Tager\Backend\Sentry\Exceptions\TagerSentryApiConfigException;
use OZiTAG\Tager\Backend\Seo\Commands\FlushSeoPagesCommand;

class TagerSentryIssue
{
    private $id;

    private $project_id;

    private $title;

    private $file;

    /** @var TagerSentryStackTraceItem[] */
    private $stacktrace = [];

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setFile($value)
    {
        $this->file = $value;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setIssueId($id)
    {
        $this->id = $id;
    }

    public function getIssueId()
    {
        return $this->id;
    }

    public function setProjectId($id)
    {
        $this->project_id = $id;
    }

    public function getProjectId()
    {
        return $this->project_id;
    }

    public function addStackTraceItem(TagerSentryStackTraceItem $item)
    {
        $this->stacktrace[] = $item;
    }

    public function setStackTraceItems(){
        return $this->stacktrace;
    }
}
