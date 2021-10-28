<table>
    <tbody>
        <tr>
            <td colspan="11">
                Sales Journal
            </td>
        </tr>
        <tr>
            <td colspan="11">
            </td>
        </tr>
        <tr>
            <td>Owner's Name</td>
            <td colspan="10">

                {{$invoices['Contact']['Name']}}
            </td>
        </tr>
        <tr>
            <td>Owner's Address</td>
            <td colspan="10">
               {{$invoices['Contact']['Addresses'][0]['AddressLine1']}} {{$invoices['Contact']['Addresses'][0]['City']}} {{$invoices['Contact']['Addresses'][0]['Region']}} {{$invoices['Contact']['Addresses'][0]['PostalCode']}}
            </td>
        </tr>

        <tr>
            <td>
                VAT Reg. TIN
            </td>
            <td colspan="10">
                {{$invoices['Contact']['TaxNumber']}}
            </td>
        </tr>
        <tr>
            <td>
                Period
            </td>
            <td colspan="10">
                {{$invoices['Date']}}
            </td>
        </tr>

        <tr>
            <td>
                Name of User
            </td>
            <td colspan="10">
                {{$invoices['Contact']['FirstName']}} {{$invoices['Contact']['LastName']}}
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
            <td>GL DATE</td>
            <td>TIN</td>
            <td>CUSTOMER NAME</td>
            <td>CUSTOMER ADDRESS</td>
            <td>DESCRIPTION</td>
            <td>INVOICE NO.</td>
            <td>REFERENCE NO.</td>
            <td>VATABLE SALES / AMOUNT</td>
            <td>VAT AMT</td>
            <td>GROSS SALES</td>
            <td>ACCOUNT CODE</td>
        </tr>

        @foreach($invoices['LineItems'] as $invoice)
            <tr>
                <td>{{ $invoices['Date']}}</td>
                <td>{{$invoices['Contact']['TaxNumber']}}</td>
                <td>{{$invoices['Contact']['Name']}}</td>
                <td>{{$invoices['Contact']['Addresses'][0]['AddressLine1']}} {{$invoices['Contact']['Addresses'][0]['City']}} {{$invoices['Contact']['Addresses'][0]['Region']}} {{$invoices['Contact']['Addresses'][0]['PostalCode']}}</td>
                <td>
                    {{$invoice['Description']}}
                </td>
                <td>
                    {{$invoices['InvoiceNumber']}}
                </td>
                <td>
                    {{$invoices['Reference']}}
                </td>
                <td>
                    {{$invoices['SubTotal']}}
                </td>
                <td>
                    {{$invoice['TaxAmount']}}
                </td>
                <td>
                    {{$invoice['UnitAmount']}}
                </td>
                <td>
                    {{$invoice['AccountCode']}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>