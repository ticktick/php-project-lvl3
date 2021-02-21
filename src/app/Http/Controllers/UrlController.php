<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UrlController extends Controller
{

    public function add(Request $request): RedirectResponse
    {
        $url       = $request->input('url')['name'];
        $validator = Validator::make(
            $request->all(),
            ['url.name' => ['required', 'url', 'max:2048']]
        );

        if ($validator->fails()) {
            flash('Invalid url: ' . $url)->error();
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $now = Carbon::now();
        $urlInfo = parse_url($url);
        $domain = mb_strtolower("{$urlInfo['scheme']}://{$urlInfo['host']}");
        $urlsTable = $this->getUrlsTable();
        $urlExists = (bool)$urlsTable->where('name', $domain)->first();

        if ($urlExists) {
            flash("Domain {$domain} already added");
        } else {
            $urlsTable->insert(
                [
                    'name'       => $domain,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
            flash("Domain {$domain} successfully added")->success();
        }
        return redirect()->back();
    }

    public function list(): View
    {
        $urls = $this->getUrlsTable()->select()->get();
        $lastChecks = $this->getUrlChecksTable()
                           ->select(DB::raw('DISTINCT ON (url_id) url_id, created_at'))
                           ->orderBy('url_id')
                           ->orderBy('created_at', 'DESC')
                           ->get()
                           ->keyBy('url_id');
        return view('urls.list', ['urls' => $urls, 'lastChecks' => $lastChecks]);
    }

    public function one(int $id): View
    {
        $url = $this->getUrlsTable()->where(['id' => $id])->first();
        if (!$url) {
            throw new NotFoundHttpException();
        }
        $checks = $this->getUrlChecksTable()
                       ->where(['url_id' => $url->id])
                       ->orderBy('created_at', 'DESC')
                       ->get();
        return view('urls.one', ['url' => $url, 'checks' => $checks]);
    }

    public function makeCheck(int $id): RedirectResponse
    {
        $url = $this->getUrlsTable()->where(['id' => $id])->first();
        if (!$url) {
            flash('No url with id ' . $id)->error();
            return redirect()->back();
        }

        $now = Carbon::now();
        $this->getUrlChecksTable()->insert(
            [
                'url_id'     => $id,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
        flash("Check for {$url->name} was run")->success();

        return redirect()->back();
    }

    private function getUrlsTable(): Builder
    {
        return DB::table('urls');
    }

    private function getUrlChecksTable(): Builder
    {
        return DB::table('url_checks');
    }
}
