<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webfox\Xero\OauthCredentialManager;
use App\Exports\UsersExport;
use App\Exports\JournalReports;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\User;

class JournalController extends Controller
{

    protected $xeroTenantId;

    public function __construct()
    {
        session_start();
        $this->xeroTenantId = $_SESSION['org']['tenant_id'];
    }
    
	public function downloadJournalReport(Request $request,OauthCredentialManager $xeroCredentials){
        $input = $request->all();
        //dd($input);
        $datas['journals'] = $input['journalReports'];
        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $orgInfo = $xero->getOrganisations($this->xeroTenantId);
        $collectedResult = collect(json_decode(json_encode($orgInfo), true))->first();  
        $datas['orgInfo'] = $collectedResult;
        $datas['dateFrom'] = $input['dateFrom'];
        $datas['dateTo'] = $input['dateTo'];
        $export = new JournalReports($datas);
        return Excel::download($export, 'journals.xlsx');
    }
}