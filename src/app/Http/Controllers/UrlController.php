<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DiDom\Exceptions\InvalidSelectorException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DiDom\Document;

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
            $newUrl = [
                'name'       => $domain,
                'updated_at' => $now,
                'created_at' => $now,
            ];
            $urlsTable->insert($newUrl);
            flash("Domain {$domain} successfully added")->success();
        }
        return redirect()->back();
    }

    public function list(): View
    {
        $urls = $this->getUrlsTable()->select()->get();
        $lastChecks = $this->getUrlChecksTable()
                           ->select(DB::raw('DISTINCT ON (url_id) url_id, created_at, status_code'))
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

        try {
            $response = Http::get($url->name);
            $html = $response->body();
            $document = new Document($html);
            $h1 = optional($document->first('h1'))->text();
            $keywords = optional($document->first('meta[name=keywords]'))->getAttribute('content');
            $description = optional($document->first('meta[name=description]'))->getAttribute('content');
            $now = Carbon::now();
            $this->getUrlChecksTable()->insert(
                [
                    'url_id'      => $id,
                    'status_code' => $response->status(),
                    'h1'          => $h1,
                    'keywords'    => $keywords,
                    'description' => $description,
                    'updated_at'  => $now,
                    'created_at'  => $now,
                ]
            );
            flash("Check for {$url->name} was run")->success();
        } catch (InvalidSelectorException $e) {
            flash(htmlspecialchars($e->getMessage()))->error();
        } catch (ConnectionException $e) {
            flash($e->getMessage())->error();
        }

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
