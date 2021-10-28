<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webfox\Xero\OauthCredentialManager;
use App\Models\User;
use Carbon\Carbon;

class ReportsController extends Controller
{

    protected $xeroTenantId;

    public function __construct()
    {
        session_start();
        $this->xeroTenantId = $_SESSION['org']['tenant_id'];
    }

	public function salesJournal(OauthCredentialManager $xeroCredentials)
    {
        return view('reports.sales-journal');
    }

    public function purchasesJournal(OauthCredentialManager $xeroCredentials)
    {
        return view('reports.purchases-journal');
    }

    public function convertDate($dateParam){
        //dd($dateParam);
        $start = '/Date(';
        $end = ')/';

        $pattern = sprintf(
            '/%s(.+?)%s/ims',
            preg_quote($start, '/'), preg_quote($end, '/')
        );

        if (preg_match($pattern, $dateParam, $matches)) {
            list(, $match) = $matches;
        }

        $mil = intval($match);
        //dd($mil2);
        $seconds = $mil / 1000;  
        return intval($seconds);
    }

    public function getJournalData(Request $request,OauthCredentialManager $xeroCredentials){
        $input = $request->all();
        // $input['dateFrom'] = '01 Jul 2021';
        // $input['dateTo'] = '31 Jul 2021';
        //$input['sourceType'] = 'ACCRECPAYMENT';

        $journalResults = [];
        $results = [];
        $firstDay = Carbon::parse($input['dateFrom'])->toDateTimeString();
        $lastDay = Carbon::parse($input['dateTo'])->toDateTimeString();
        $paymentResult = [];
        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $getContacts = $xero->getContacts($this->xeroTenantId);
        $contacts = collect(json_decode(json_encode($getContacts), true))->toArray();
        //$contacts = $xero->getContact($this->xeroTenantId, "04479cd1-fdd6-4cb4-80a7-7fc8c836e03f");
        //dd(collect(json_decode(json_encode($contacts), true))->toArray());
        $offset = 0;
        for($i=0;$i<=10000;$i +=100){
            $result[] = $xero->getJournals($this->xeroTenantId,Carbon::parse($firstDay)->toIso8601String(), $offset);  
            $count = array_sum(array_map("count", $result));
            if($i <= $count){
                $offset +=100;
            }else{
                break;
            }
        }

        $collectedResult = collect(json_decode(json_encode($result), true))->sortByDesc('CreatedDateUTC')->toArray();

        $new = array();
        $newArr = [];
        foreach($collectedResult as $val) {
            foreach($val as $key => $value){
                if(isset($value['SourceType']) && $value['SourceType'] === $input['sourceType']){
                    $credit = 0;
                    $debit = 0;

                    $journalDate = $value['JournalDate'];
                    $createdDateUTC = $value['CreatedDateUTC'];
                    
                    $value['modifiedJournalDate'] = Carbon::parse($this->convertDate($journalDate))->toDateTimeString();
                    $value['createdDateUTC'] = Carbon::parse($this->convertDate($createdDateUTC))->toDateTimeString();

                    foreach ($value['JournalLines'] as $key => $data) {
                        if($data['NetAmount'] < 0){
                            $credit += $data['NetAmount'];
                        }

                        if($data['NetAmount'] > 0){
                            $debit += $data['NetAmount'];
                        }
                        
                    }

                    $value['TotalCredit'] = $credit;
                    $value['TotalDebit'] = $debit;
                    $results[] = $value;
                }
            }
        }

        if(collect($results)->count() == 0){
            return $journalResults;
        }

        $modifiedResult = collect(json_decode(json_encode($results), true))->whereBetween('modifiedJournalDate', [$firstDay, $lastDay])->values()->toArray();
        //dd($modifiedResult);
        //collecting of invoice and payment methods
        $pageOffset = 1;
        for($i=0;$i<=10000;$i +=100){
            if($input['sourceType'] === 'ACCRECPAYMENT' || $input['sourceType'] === 'ACCPAYPAYMENT'){
                $paymentResult[] = $xero->getPayments($this->xeroTenantId,Carbon::parse($firstDay)->toIso8601String(),null,null, $pageOffset);  
            }

            if($input['sourceType'] === 'ACCPAY' || $input['sourceType']  === 'ACCREC'){
                $paymentResult[] = $xero->getInvoices($this->xeroTenantId,Carbon::parse($firstDay)->toIso8601String(),null,null,null,null,null,null, $pageOffset);  
            }
            $count = collect(json_decode(json_encode($paymentResult), true)[0])->sortByDesc('CreatedDateUTC')->count();

            if($i <= $count){
                $pageOffset +=1;
            }else{
                break;
            }
        }
        $collectedPaymentResult = collect(json_decode(json_encode($paymentResult), true))->sortByDesc('Date')->toArray();

        foreach($collectedPaymentResult as $val) {
            foreach($val as $key => $value){
                $paymentResults[] = $value;
            }
        }
        //end collection of invoice and payment methods

        foreach ($modifiedResult as $key => $data) {
            //dd($data);
            if(isset($data['SourceType']) && $data['SourceType'] == $input['sourceType']){
                $paymentId = $data['SourceID'];
                

                if($input['sourceType'] === 'ACCRECPAYMENT' || $input['sourceType'] === 'ACCPAYPAYMENT'){
                    $result2 = collect($paymentResults)->where('PaymentID',$paymentId);
                }

                if($input['sourceType'] === 'ACCPAY' || $input['sourceType']  === 'ACCREC'){
                    $result2 = collect($paymentResults)->where('InvoiceID',$paymentId);
                }

                $paymentResult = collect(json_decode(json_encode($result2), true))->first();  
                //dd($paymentResult['Invoice']['Contact']['ContactID']);
                $data['contact'] = collect($contacts)->where('ContactID', $paymentResult['Invoice']['Contact']['ContactID'])->first();
                $data['paymentData'] = $paymentResult;
                $journalResults[] = $data;
            }
            
        }
        //dd(collect($journalResults)->sortByDesc('JournalNumber')->unique('JournalNumber')->values()->toArray());
        return collect($journalResults)->sortByDesc('JournalNumber')->unique('JournalNumber')->values()->toArray();
    }
}