<table>
    <tbody>
        <tr>
            <td>REGISTERED NAME</td>
            <td colspan="7">
                {{$data['orgInfo']['LegalName']}}
            </td>

            <td>
                PERMIT TO USE NO.
            </td>
            <td>
                :
            </td>
        </tr>   
        <tr>
            <td>
                {{strtoupper('VAT Reg. TIN')}}
            </td>
            <td colspan="7">
                {{$data['orgInfo']['TaxNumber']}}
            </td>

            <td>
                NAME OF USER
            </td>
            <td>
                 {{$data['orgInfo']['Name']}}
            </td>
        </tr>
        <tr>
            <td>{{strtoupper('Registered Address')}}</td>
            <td colspan="7">
                @if(isset($data['orgInfo']['Addresses'][0]))
                    {{$data['orgInfo']['Addresses'][0]['City']}}, {{$data['orgInfo']['Addresses'][0]['Region']}}, {{$data['orgInfo']['Addresses'][0]['PostalCode']}}
                @endif
            </td>

            <td>
                RUN DATE
            </td>
            <td>
                {{date('m-d-Y')}}
            </td>
        </tr>

        <!-- <tr>
            <td>
                {{strtoupper('For the month of')}}
            </td>
            <td colspan="10">
                July
            </td>
        </tr> -->
        <tr>
            <td colspan="7">
                {{$data['journalType']}}
            </td>
        </tr>

        <tr>
            <td colspan="7">
            </td>
        </tr>
        <tr>
            <td colspan="7">
            </td>
        </tr>

        <tr>
            <td>DATE</td>
            <td>OR NUMBER</td>
            <td>CUSTOMER NAME</td>
            <td>TIN</td>
            <td>CUSTOMER ADDRESS</td>
            <td>INVOICE NO.</td>
            <td>DESCRIPTION</td>
            <td>INVOICE NO.</td>
            <td>ACCOUNTS RECEIVABLE(CREDIT)</td>
            <td>AMOUNT PAID</td>
            <td>ACCOUNT CODE(DEBIT)</td>
            <td>ACCOUNT TITLE</td>
        </tr>

        @foreach($data['reports'] as $reports)
            @foreach($reports['LineItems'] as $report)
            @if($report['AccountCode'] == 200)
                    <tr>
                        <td>{{ $reports['Date']}}</td>
                        <td></td>
                        <td>{{ $reports['Contact']['Info']['Name'] }}</td>
                        <td>{{ !empty($reports['Contact']['Info']['TaxNumber']) ? $reports['Contact']['Info']['TaxNumber'] : '' }}</td>
                        <td>
                            {{!empty($reports['Contact']['Info']['Addresses'][0]['AddressLine1']) ? $reports['Contact']['Info']['Addresses'][0]['AddressLine1'] : ''}}  
                        </td>
                        <td>
                            {{$reports['paymentData']['Invoice']['InvoiceNumber']}}
                        </td>
                        <td>
                            {{$report['Description']}}
                        </td>
                        <td>
                            @if($data['journalType'] == 'CASH RECEIPT')
                                {{-- isset($reports['paymentData']['batchPaymentData']) ? $reports['paymentData']['batchPaymentData']['Reference'].'/'.$reports['paymentData']['batchPaymentData']['Payments']['Details'] : '' --}}

                                {{$reports['paymentData']['Invoice']['InvoiceNumber']}}
                            @endif


                            @if($data['journalType'] == 'CASH DISBURSEMENT')
                                {{ !empty($reports['paymentData']['batchPaymentData']['Details']) ? $reports['paymentData']['batchPaymentData']['Details'].'/'.$reports['paymentData']['batchPaymentData']['Payments']['Details'] : '' }}
                            @endif
                        </td>
                        <td>
                            {{$reports['paymentData']['InvoiceResult']['AmountPaid']}}
                        </td>
                        <td>
                            {{$reports['paymentData']['InvoiceResult']['AmountPaid']}}
                        </td>
                        <td style="text-align:right;">
                            {{ (isset($reports['paymentData']['Account']['Code'])) ? $reports['paymentData']['Account']['Code'] : '' }}
                        </td>

                        <td>
                            @foreach($reports['JournalLines'] as $key => $val)
                                @if(isset($val['AccountCode'] )&& $val['AccountCode'] != '800')
                                    {{$val['AccountName']}}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>