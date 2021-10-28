<table>
    <tbody>
        <tr>
            <td>Attachment to BIR Form 1601-EQ</td>
        </tr>
        <tr>
            <td>QUARTERLY ALPHABETICAL LIST OF PAYEES SUBJECTED TO EXPANDED WITHHOLDING TAX & PAYEES WHOSE INCOME PAYMENTS ARE EXEMPT</td>
        </tr>
        <tr>
            <td>FOR THE QUARTER ENDING {{$data['dateTo']}}</td>
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

       
    </tbody>
</table>