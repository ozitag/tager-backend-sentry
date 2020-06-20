<?php

namespace OZiTAG\Tager\Backend\Sentry\Api;

use Illuminate\Support\ServiceProvider;
use OZiTAG\Tager\Backend\Sentry\Exceptions\TagerSentryApiAuthorizationException;
use OZiTAG\Tager\Backend\Sentry\Exceptions\TagerSentryApiConfigException;
use OZiTAG\Tager\Backend\Seo\Commands\FlushSeoPagesCommand;

class TagerSentryApi
{
    private $organization;
    private $project;
    private $token;

    public function __construct()
    {
        $this->token = config('tager-sentry.token');
        if (empty($this->token)) {
            throw new TagerSentryApiConfigException('Organization is not set (tager-sentry.token)');
        }

        $this->organization = config('tager-sentry.organization');
        $this->validateOrganization();

        $this->project = config('tager-sentry.project');
        $this->validateProject();;
    }

    private function validateOrganization()
    {
        if (empty($this->organization)) {
            throw new TagerSentryApiConfigException('Organization is not set (tager-sentry.organization)');
        }

        $organization = $this->httpSentryRequest('https://sentry.io/api/0/organizations/' . $this->organization . '/');
        if (!$organization) {
            throw new TagerSentryApiConfigException('Organization "' . $this->organization . '" is not found');
        }
    }

    private function validateProject()
    {
        if (empty($this->project)) {
            throw new TagerSentryApiConfigException('Project is not set (tager-sentry.project)');
        }

        $project = $this->httpSentryRequest('https://sentry.io/api/0/organizations/' . $this->organization . '/' . $this->project . '/');
        if (!$project) {
            throw new TagerSentryApiConfigException('Project "' . $this->project . '" is not found');
        }
    }

    private function getSentryApiIssueUrl($issueId)
    {
        return 'https://sentry.io/api/0/projects/' . $this->organization . '/' . $this->project . '/events/' . $issueId . '/';
    }

    public function getSentryIssueViewUrl($projectId, $issueId)
    {
        return 'https://sentry.io/organizations/' . $this->organization . '/issues/' . $issueId . '/?project=' . $projectId;
    }

    private function httpSentryRequest($url)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token
        ]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);

        if ($curlInfo['http_code'] == 401) {
            throw new TagerSentryApiAuthorizationException();
        }

        if ($curlInfo['http_code'] == 404) {
            return null;
        }

        return json_decode($response, true);
    }

    /**
     * @param $issueId
     * @return TagerSentryIssue;
     * @throws TagerSentryApiAuthorizationException
     */
    public function getIssueInfo($issueId)
    {
        $response = $this->httpSentryRequest($this->getSentryApiIssueUrl($issueId));

        if (!$response || isset($response['detail']) && $response['detail'] == 'Event not found') {
            return null;
        }

        $model = new TagerSentryIssue();

        if (isset($response['eventID'])) {
            $model->setIssueId($response['eventID']);
        }

        if (isset($response['projectID'])) {
            $model->setProjectId($response['projectID']);
        }

        if (isset($response['title'])) {
            $model->setTitle($response['title']);
        }

        if (isset($response['location'])) {
            $model->setFile($response['location']);
        }

        if (isset($response['entries'][0]['data']['values'][0]['stacktrace']['frames'])) {
            foreach ($response['entries'][0]['data']['values'][0]['stacktrace']['frames'] as $frame) {
                $stackTraceItem = new TagerSentryStackTraceItem();
                if (isset($frame['filename'])) {
                    $stackTraceItem->setFile($frame['filename']);
                }
                if (isset($frame['lineNo'])) {
                    $stackTraceItem->setLine($frame['lineNo']);
                }
                if (isset($frame['colNo'])) {
                    $stackTraceItem->setCol($frame['colNo']);

                }
                if (isset($frame['function'])) {
                    $stackTraceItem->setFunction($frame['function']);
                }
                if (isset($frame['context'])) {
                    foreach ($frame['context'] as $contextItem) {
                        if (is_array($contextItem) && count($contextItem) > 1) {
                            $stackTraceItem->addCodeLine($contextItem[0], $contextItem[1]);
                        }
                    }
                }
                $model->addStackTraceItem($stackTraceItem);
            }
        }

        return $model;
    }

}
