<?php

namespace OZiTAG\Tager\Backend\Sentry\Features;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Sentry\Resources\IssueResource;
use OZiTAG\Tager\Backend\Sentry\Exceptions\TagerSentryApiAuthorizationException;
use OZiTAG\Tager\Backend\Sentry\Exceptions\TagerSentryApiConfigException;
use OZiTAG\Tager\Backend\Sentry\Api\TagerSentryApi;

class ViewIssueFeature extends Feature
{
    private $issue;

    public function __construct($issue)
    {
        $this->issue = $issue;
    }

    public function handle()
    {
        try {
            $sentryApi = new TagerSentryApi();
        } catch (TagerSentryApiConfigException $exception) {
            abort(400, 'TAGER Sentry Configuration Error - ' . $exception->getMessage());
        }

        try {
            $issue = $sentryApi->getIssueInfo($this->issue);
            if (!$issue) {
                abort(400, 'Issue #' . $this->issue . ' not found on Sentry');
            }
        } catch (TagerSentryApiAuthorizationException $exception) {
            abort(400, 'TAGER Sentry Backend Error - Invalid Sentry Token');
        }

        return new IssueResource($issue, $sentryApi->getSentryIssueViewUrl($issue->getProjectId(), $issue->getIssueId()));
    }
}
