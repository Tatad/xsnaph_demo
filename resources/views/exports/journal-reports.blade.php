{{--dd($journals)--}}

<table style="width:100%">
    <tbody>
    	<tr>
    		<td colspan="3" style="text-align:center;font-size:16px; font-weight: bold"><h2>Journal Report</h2></td>
    	</tr>
    	<tr>
			<td colspan="3" style="text-align:center;font-size:14px; font-weight: bold"><h4>{{$journals['orgInfo']['LegalName']}}</h4></td>
    	</tr>

    	<tr>
			<td colspan="3" style="text-align:center;font-size:12px; font-weight: bold">From {{$journals['dateFrom']}} - to {{$journals['dateTo']}}</td>
    	</tr>
        <tr>
            <td>Date</td>
            <td>TIN</td>
            <td>Name</td>
            <td>Invoice No.</td>
            <td>Amount</td>
        </tr>
        @foreach($journals['journals'] as $data)
            <tr>
                <td>{{$data['modifiedJournalDate']}}</td>
                <td>{{isset($data['contact']['TaxNumber']) ? $data['contact']['TaxNumber'] : 'N/A'}}</td>
                <td>{{$data['contact']['Name']}}</td>
                <td>{{$data['paymentData']['Invoice']['InvoiceNumber']}}</td>
                <td>{{'₱'.$data['paymentData']['Amount']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>