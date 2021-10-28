<template>
    <div>
        <h5>Date Range</h5>
        <div class="row" style="padding-bottom:2rem">
            <div class="col-md-3">
                <select class="form-control" v-model="form.type" @change="modifyDate()">
                    <option :selected="form.type == 'thisMonth'" value="thisMonth">This Month</option>
                    <option :selected="form.type == 'previousMonth'" value="previousMonth">Previous Month</option>
                    <option :selected="form.type == 'lastQuarter'" value="lastQuarter">Last Quarter</option>
                    <option :selected="form.type == 'thisQuarter'" value="thisQuarter">This Quarter</option>
                    <option :selected="form.type == 'lastFinancialYear'" value="lastFinancialYear">Last Financial Year</option>
                    <option :selected="form.type == 'thisFinancialYear'" value="thisFinancialYear">This Financial Year</option>
                    <option :selected="form.type == 'custom'" value="custom">Custom</option>
                </select>
            </div>
            <div class="col-md-2">
                <datepicker @closed="doSomethingInParentComponentFunction" required input-class="form-control" id="dateFrom" v-model="form.dateFrom" name="dateFrom" placeholder="Date From" :disabledDates="state.disabledDates"></datepicker>
            </div>

            <div class="col-md-2">
                <datepicker required input-class="form-control" id="dateTo" v-model="form.dateTo" name="dateTo" placeholder="Date To"></datepicker>
            </div>
            <div class="col-md-5">
                <button class="btn btn-primary" @click.prevent="getJournalReports()">Submit</button>

                <button v-if="empty == '0'" class="btn btn-primary" @click.prevent="downloadJournalReport(filteredList)">Download</button>
            </div>
        </div>

        <div v-if="empty != 1">
            <div v-for="journal in filteredList">
                <div class="row" style="border-bottom:2px solid #bababa;">
                </div>
            </div>
            <v-client-table :columns="['modifiedJournalDate','contact.TaxNumber','contact.Name','paymentData.Invoice.InvoiceNumber','paymentData.Amount']" :data="journalReports" :options="options">
                 <div slot="modifiedJournalDate" slot-scope="props">
                    {{props.row.modifiedJournalDate | formatDate}}
                 </div>

                 <div slot="paymentData.Amount" slot-scope="props">
                    {{'₱' + props.row.paymentData.Amount | filterText}}
                 </div>
            </v-client-table>
            <div v-if="filteredList.length == '0'" class="text-center" style="padding-top:5rem">
                <h1 style="font-size:24px">No Records to show.</h1>
            </div>
        </div>
        <div v-if="isLoading == 0 && empty == 1" class="text-center" style="padding-top:5rem">
            <h1 v-show="filteredList == ''" style="font-size:24px">No Records to show.</h1>
        </div>
        <div  v-if="isLoading == 1" class="text-center" style="padding-top:5rem">
            <h1 style="font-size:24px"><i class="text-center fa fa-spinner fa-spin"></i></h1>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    Vue.filter('filterText', function(value) {
        if(value){
            return (value.replace('-',''))
        }
    })

    Vue.filter('formatDate', function(value) {
      if (value) {
        return moment(String(value)).format('D/M/YYYY')
      }
    })
    import Datepicker from 'vuejs-datepicker';
    import {ServerTable, ClientTable, Event} from 'vue-tables-2';

    Vue.use(ClientTable, {
        
    });

    Vue.filter('formatDate', function(value) {
        if (value) {
            return moment(String(value)).format('D MMM Y')
        }
    })
    export default{
        components: {
            Datepicker,
            moment
        },
        data(){
            return{
                search: '',
                form: {
                    'dateFrom' : moment().startOf('month').format('D MMM Y'),
                    'dateTo': moment().endOf('month').format('D MMM Y'),
                    'type' : 'thisMonth',
                    'id' : '',
                    'sourceType' : 'ACCRECPAYMENT'
                },  
                state:{
                    disabledDates: {
                        from: new Date(), // Disable all dates after specific date
                    },
                    disabledDate: {
                        from: new Date(), // Disable all dates after specific date
                    }      
                },
                journalReports: [],
                options: {
                    perPage: 25,
                    sortIcon: {
                        base : 'fa',
                        is: 'fa-sort',
                        up: 'fa-sort-asc',
                        down: 'fa-sort-desc'
                    },
                    headings:{
                        'modifiedJournalDate' : 'Date',
                        'contact.TaxNumber' : 'TIN',
                        'contact.Name' : 'Name',
                        'paymentData.Invoice.InvoiceNumber' : 'Invoice No.',
                        'paymentData.Amount' : 'Amount'
                    }
                },
                filterJournal : 'accrecpayment',
                journalReportsDownloads: {'dateFrom': moment().startOf('month').format('D MMM Y'), 'dateTo' : moment().endOf('month').format('D MMM Y'), 'journalReports' : []},
                empty: 1,
                isLoading: 1
            }
        },
        computed:{
            filteredList() {
              return this.journalReports.filter(journals => {
                if(this.filterJournal == 'all'){
                    this.forJournalDownload = journals.paymentData.Contact.Name.toLowerCase().includes(this.search.toLowerCase())
                    return journals.paymentData.Contact.Name.toLowerCase().includes(this.search.toLowerCase())
                }

                if(journals.SourceType && this.filterJournal == 'accrec'){
                    if(journals.SourceType.toLowerCase() == 'accrec'){
                        this.forJournalDownload = journals
                        return journals
                    }
                }

                if(journals.SourceType && this.filterJournal == 'accpay'){
                    if(journals.SourceType.toLowerCase() == 'accpay'){
                        this.forJournalDownload = journals
                        return journals
                    }
                }

                if(journals.SourceType && this.filterJournal == 'accrecpayment'){
                    if(journals.SourceType.toLowerCase() == 'accrecpayment'){
                        this.forJournalDownload = journals
                        return journals
                    }
                }

                if(journals.SourceType && this.filterJournal == 'accpaypayment'){
                    if(journals.SourceType.toLowerCase() == 'accpaypayment'){
                        this.forJournalDownload = journals
                        return journals
                    }
                }

                if(this.filterJournal == 'general'){
                    this.forJournalDownload = journals
                    return !journals.SourceType
                }
              })
            },
        },
        mounted(){
            this.getJournalReports()
        },
        methods:{
            doSomethingInParentComponentFunction(){
                this.state.disabledDate.to =  this.form.dateFrom
                this.state.disabledDate.from =  new Date()
                this.form.type = 'custom'
            },
            modifyDate(){
                if(this.form.type == 'thisMonth'){
                    this.form.dateFrom = moment().startOf('month').format('D MMM Y')
                    this.form.dateTo = moment().endOf('month').format('D MMM Y')
                }

                if(this.form.type == 'previousMonth'){
                    this.form.dateFrom = moment().subtract(1,'months').startOf('month').format('D MMM Y');
                    this.form.dateTo = moment().subtract(1,'months').endOf('month').format('D MMM Y');
                }

                if(this.form.type == 'thisQuarter'){
                    this.form.dateFrom = moment().startOf('quarter').format('D MMM Y');
                    this.form.dateTo = moment().endOf('quarter').format('D MMM Y');
                }

                if(this.form.type == 'lastQuarter'){
                    var lastQuarter = moment().subtract(1, 'ms').quarter() - 1;
                    this.form.dateFrom = moment().startOf('quarter').quarter(lastQuarter).format('D MMM Y')
                    this.form.dateTo = moment().endOf('quarter').quarter(lastQuarter).format('D MMM Y')
                }

                if(this.form.type == 'thisFinancialYear'){
                    this.form.dateFrom = moment().startOf('year').format('D MMM Y');
                    this.form.dateTo = moment().endOf('year').format('D MMM Y');
                }

                if(this.form.type == 'lastFinancialYear'){
                    var lastYear = moment().subtract(1, 'ms').year() - 1;
                    this.form.dateFrom = moment().startOf('year').year(lastYear).format('D MMM Y')
                    this.form.dateTo = moment().endOf('year').year(lastYear).format('D MMM Y')
                }
            },
            getJournalReports(){
                    this.isLoading = 1
                axios.post('/get-journal-data',this.form).then((response) => {
                    if(response.data.length != 0){
                        this.empty = 0
                    }else{
                        this.empty = 1
                    }
                    
                    console.log('empty',this.empty)
                    this.isLoading = 0
                    this.journalReports = response.data
                })
            },
            downloadJournalReport(journalReports){
                this.journalReportsDownloads.journalReports = journalReports
                this.journalReportsDownloads.dateFrom = this.form.dateFrom
                this.journalReportsDownloads.dateTo = this.form.dateTo
                console.log(this.journalReportsDownloads)
                axios.post('/download-journal',this.journalReportsDownloads,
                {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/vnd.ms-excel'
                    },
                    responseType: "blob"
                }).then((response) => {
                    //window.open(response.data,'_blank');
                    console.log(response.data);
                    let blob = new Blob([response.data], { type: 'application/vnd.ms-excel' })
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = 'sales-journals'+'.xlsx'
                    link.click()
                })
            }
        }
    }
</script>

<style type="text/css">
    
</style>