<?php

namespace App\Http\Controllers\Newsletter;

use App\Models\Newsletter\Lead;
use App\Http\Controllers\Controller;
use App\Http\Resources\Newsletter\Lead as LeadResource;
use App\Http\Requests\Newsletter\Lead as LeadRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    public function index()
    {
        $query = Lead::query();

        return LeadResource::collection($query->paginate());
    }

    /**
     * Export all newsletter leads to CSV file.
     *
     * @return
     */
    public function export()
    {
        $file = 'reports/csv/leads.csv';
        $content = '';
        $leads = Lead::get(['name', 'email'])->all();

        foreach ($leads as $lead) {
            $content .= $lead->name . ';' . $lead->email . "\n";
        }

        Storage::disk('local')->put($file, $content);

        return Storage::download($file);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LeadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function signin(LeadRequest $request)
    {
        return new LeadResource(
            Lead::create($request->all())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function signout($token)
    {
        $feeder = Lead::whereToken($token)->first();

        if (! $feeder) {
            return response('Invalid token', 400);
        }

        $feeder->disable();

        return 'oka';
    }
}
