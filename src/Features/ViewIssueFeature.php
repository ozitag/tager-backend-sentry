<?php

namespace OZiTAG\Tager\Backend\Seo\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Feature;
use OZiTAG\Tager\Backend\Seo\Jobs\GetSeoPageJobByAlias;
use OZiTAG\Tager\Backend\Seo\Resources\PublicSeoResource;

class ViewIssueFeature extends Feature
{
    private $issue;

    public function __construct($issue)
    {
        $this->issue = $issue;
    }

    public function handle()
    {
        return new JsonResource([
            'title' => 'TypeError: {}.toLowerCase is not a function',
            'file' => 'D:\\Documents\\Work\\presetbox\\web\\.next\\server\\static\\O90AXyfFVwqIrbOWxz-MX\\pages\\custom-error.js',
            'sentryUrl' => 'https://sentry.io/organizations/ozitag-2v/issues/1733479101/?project=5266845',
            'stacktrace' => [
                [
                    'file' => 'D:\\Documents\\Work\\presetbox\\web\\.next\\server\\static\\O90AXyfFVwqIrbOWxz-MX\\pages\\_document.js',
                    'line' => 280,
                    'code' => [
                        '273' => '',
                        '274' => '      return props => /*#__PURE__*/_react.default.createElement(App, props);"',
                        '275' => '    };'
                    ]
                ],
                [
                    'file' => 'D:\\Documents\\Work\\presetbox\\web\\.next\\server\\static\\O90AXyfFVwqIrbOWxz-MX\\pages\\_document.js',
                    'line' => 280,
                    'code' => [
                        '273' => '',
                        '274' => '      return props => /*#__PURE__*/_react.default.createElement(App, props);"',
                        '275' => '    };'
                    ]
                ],
                [
                    'file' => 'D:\\Documents\\Work\\presetbox\\web\\.next\\server\\static\\O90AXyfFVwqIrbOWxz-MX\\pages\\_document.js',
                    'line' => 280,
                    'code' => [
                        '273' => '',
                        '274' => '      return props => /*#__PURE__*/_react.default.createElement(App, props);"',
                        '275' => '    };'
                    ]
                ]
            ]
        ]);
    }
}
