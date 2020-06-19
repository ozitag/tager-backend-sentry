<?php

namespace OZiTAG\Tager\Backend\Sentry\Controllers;

use OZiTAG\Tager\Backend\Core\Controller;
use OZiTAG\Tager\Backend\Sentry\Features\ViewIssueFeature;

class SentryController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function issue($issue)
    {
        return $this->serve(ViewIssueFeature::class, [
            'issue' => $issue
        ]);
    }
}
