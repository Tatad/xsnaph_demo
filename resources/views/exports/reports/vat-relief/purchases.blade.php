<table>
    <tbody>
        <tr>
            <td>PURCHASE TRANSACTION</td>
        </tr>
        <tr>
            <td>RECONCILIATION OF LISTING FOR ENFORCEMENT</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>TIN: {{$data['orgInfo']['TaxNumber']}}</td>
        </tr>   
        <tr>
            <td>OWNER'S NAME: {{$data['orgInfo']['LegalName']}}</td>
        </tr> 
        <tr>
            <td>OWNER'S TRADE NAME: {{$data['orgInfo']['LegalName']}}</td>
        </tr>  
        <tr>
            <td>OWNER'S ADDRESS: {{$data['orgInfo']['Addresses'][0]['AddressLine1']}}, {{$data['orgInfo']['Addresses'][0]['City']}}, {{$data['orgInfo']['Addresses'][0]['Region']}}, {{$data['orgInfo']['Addresses'][0]['Country']}}, {{$data['orgInfo']['Addresses'][0]['PostalCode']}}</td>
        </tr> 

        <tr>
            <td>TAXABLE MONTH</td>
            <td>TAXPAYER IDENTIFICATION</td>
            <td>REGISTERED NAME</td>
            <td>NAME OF CUSTOMER</td>
            <td>CUSTOMER's ADDRESS</td>
            <td>AMOUNT OF GROSS PURCHASE</td>
            <td>AMOUNT OF EXEMPT PURCHASE</td>
            <td>AMOUNT OF ZERO RATED PURCHASE</td>
            <td>AMOUNT OF TAXABLE PURCHASE</td>
            <td>AMOUNT OF PURCHASE OF SERVICES</td>
            <td>AMOUNT OF PURCHASE OF CAPITAL GOODS</td>
            <td>AMOUNT OF PURCHASE OF GOODS OTHER THAN CAPITAL GOODS</td>
            <td>AMOUNT OF INPUT TAX</td>
            <td>AMOUNT OF GROSS TAXABLE PURCHASE</td>
        </tr>  
        <?php $totalNet = 0;?>
        <?php $totalTax = 0;?>
        <?php $totalGross = 0;?>
        @foreach($data['data'] as $key => $record)
            <tr>
                <td>{{$data['dateTo']}}</td>
                <td>{{$record['tinNumber']}}</td>
                <td>{{$record['contact']}}</td>
                <td>{{$record['contact']}}</td>
                <td>{{$record['address']}}</td>
                <td  style="text-align: right;" data-format="0.00">{{ number_format($record['net'],2) }}</td>
                <td  style="text-align: right;" data-format="0.00">0.00</td>
                <td  style="text-align: right;" data-format="0.00">0.00</td>
                <td  style="text-align: right;" data-format="0.00">{{number_format($record['net'],2)}}</td>
                <td  style="text-align: right;" data-format="0.00">{{ ($data['type'] == 'purchases') ? number_format($record['net'],2) : 0 }}</td>
                <td  style="text-align: right;" data-format="0.00">{{ ($data['type'] == 'goods') ? number_format($record['net'],2) : 0 }}</td>
                <td  style="text-align: right;" data-format="0.00">0.00</td>
                <td  style="text-align: right;" data-format="0.00">{{number_format($record['tax'],2)}}</td>
                <td  style="text-align: right;" data-format="0.00">{{number_format($record['gross'],2)}}</td>
            </tr>
            <?php $totalNet += $record['net'];?>
            <?php $totalTax += $record['tax'];?>
            <?php $totalGross += $record['gross'];?>
        @endforeach
        <tr>
            <td>Grand Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: right;"  data-format="0.00">{{number_format($totalNet,2)}}</td>
            <td style="text-align: right;"  data-format="0.00">0</td>
            <td style="text-align: right;"  data-format="0.00">0</td>
            <td style="text-align: right;"  data-format="0.00">{{number_format($totalNet,2)}}</td>
                <td  style="text-align: right;" data-format="0.00">{{ ($data['type'] == 'purchases') ? number_format($totalNet,2) : 0 }}</td>
                <td  style="text-align: right;" data-format="0.00">{{ ($data['type'] == 'goods') ? number_format($totalNet,2) : 0 }}</td>
            <td style="text-align: right;"  data-format="0.00">0</td>
            <td style="text-align: right;"  data-format="0.00">{{number_format($totalTax,2)}}</td>
            <td style="text-align: right;"  data-format="0.00">{{(number_format($totalGross,2))}}</td>
        </tr>
    </tbody>
</table>