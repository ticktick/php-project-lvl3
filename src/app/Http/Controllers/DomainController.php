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

class DomainController extends Controller
{

    private function getDomainsTable(): Builder
    {
        return DB::table('domains');
    }

    public function add(Request $request): RedirectResponse
    {
        $url       = $request->input('domain')['name'];
        $validator = Validator::make(
            $request->all(),
            ['domain.name' => ['required', 'url', 'max:2048']]
        );

        if ($validator->fails()) {
            flash('Invalid url: ' . $url)->error();
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $now = Carbon::now();
        $urlInfo = parse_url($url);
        $domain = mb_strtolower("{$urlInfo['scheme']}://{$urlInfo['host']}");
        $domainsTable = $this->getDomainsTable();
        $domainExists = (bool)$domainsTable->where('name', $domain)->first();

        if ($domainExists) {
            flash("Domain {$domain} already added");
        } else {
            DB::table('domains')->insert(
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
        $domains = $this->getDomainsTable()->select()->get();
        return view('domain.list', ['domains' => $domains]);
    }

    public function one(int $id): View
    {
        $domain = $this->getDomainsTable()->where(['id' => $id])->first();
        if (!$domain) {
            throw new NotFoundHttpException();
        }
        return view('domain.one', ['domain' => $domain]);
    }
}
