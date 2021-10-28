<table>
    <tbody>
        <tr>
            <td>REGISTERED NAME</td>
            <td colspan="10">
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
            <td colspan="10">
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
            <td colspan="10">
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
            <td colspan="11">
                {{$data['journalType']}}
            </td>
        </tr>

        <tr>
            <td colspan="11">
            </td>
        </tr>
        <tr>
            <td colspan="11">
            </td>
        </tr>

        <tr>
            <td>DATE</td>
            <td>CUSTOMER NAME</td>
            <td>TIN</td>
            <td>CUSTOMER ADDRESS</td>
            <td>INVOICE NO.</td>
            <td>DESCRIPTION</td>
            <td>REFERENCE NO.</td>
            <td>VATABLE SALES (EXCLUSIVE OF VAT)</td>
            <td>VAT EXEMPT SALES</td>
            <td>ZERO RATED SALES</td>
            <td>VAT AMOUNT</td>
            <td>DISCOUNT</td>
            <td>GROSS SALES</td>
            <td>ACCOUNT CODE</td>
            <td>ACCOUNT TITLE</td>
        </tr>

        @foreach($data['reports'] as $reports)
            {{--dd($reports['paymentData'])--}}
            @foreach($reports['LineItems'] as $report)
                <tr>
                    <td>{{ $reports['Date']}}</td>
                    <td>{{ $reports['Contact']['Info']['Name'] }}</td>
                    <td>{{ !empty($reports['Contact']['Info']['TaxNumber']) ? $reports['Contact']['Info']['TaxNumber'] : '' }}</td>
                    <td>
                        {{!empty($reports['Contact']['Info']['Addresses'][0]['AddressLine1']) ? $reports['Contact']['Info']['Addresses'][0]['AddressLine1'] : ''}} {{$reports['Contact']['Info']['Addresses'][0]['City']}} {{$reports['Contact']['Info']['Addresses'][0]['Region']}} {{$reports['Contact']['Info']['Addresses'][0]['PostalCode']}}
                    </td>
                    <td>
                        {{$reports['paymentData']['InvoiceNumber']}}
                    </td>
                    <td>
                        {{$report['Description']}}
                    </td>
                    <td>
                        {{ (isset($reports['Payments'][0])) ? (isset($reports['Payments'][0]['Reference'])) ? $reports['Payments'][0]['Reference'] : 'N/A' : 'N/A'}}
                    </td>
                    <td>
                        {{$reports['paymentData']['SubTotal']}}
                    </td>
                    <td>
                        {{$reports['paymentData']['Total']}}
                    </td>
                    <td>
                        {{$reports['paymentData']['TotalTax']}}
                    </td>
                    <td>
                        0
                    </td>

                    <td>
                        
                    </td>
                    <td>
                        {{$report['UnitAmount']}}
                    </td>
                    <td>
                        {{$report['AccountCode']}}
                    </td>

                    <td>
                        {{$report['accountTitle']}}
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>