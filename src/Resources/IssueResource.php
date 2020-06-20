<?php

namespace OZiTAG\Tager\Backend\Sentry\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Sentry\Api\TagerSentryStackTraceItem;

class IssueResource extends JsonResource
{
    private $url;

    public function __construct($resource, $issueViewUrl)
    {
        $this->url = $issueViewUrl;
        parent::__construct($resource);
    }

    private function getStackTrace()
    {
        $stackTrace = $this->setStackTraceItems();

        return array_map(function (TagerSentryStackTraceItem $item) {
            $codeArray = [];

            foreach ($item->getCodeLines() as $line => $code) {
                $codeArray[] = ['line' => $line, 'code' => $code];
            }

            return [
                'file' => $item->getFile(),
                'line' => $item->getLine(),
                'col' => $item->getCol(),
                'function' => $item->getFunction(),
                'code' => $codeArray
            ];
        }, $stackTrace);
    }

    public function toArray($request)
    {
        return [
            'title' => $this->getTitle(),
            'file' => $this->getFile(),
            'sentryUrl' => $this->url,
            'stacktrace' => $this->getStackTrace()
        ];
    }
}
