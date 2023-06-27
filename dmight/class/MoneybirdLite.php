<?
class MoneybirdLite {

    private $apiToken;
    private $administrationId;
    private $apiBaseUrl;
    public $client;
    public $apiSubUrl;

    function __construct(
        string $token   = 'LtBcduSnJkTBJPqrWj2Bzhxx94sdtzDmoc8hODf7f9s',
        string $adminId = '347325906349458676'
        )
    {
        $this->apiToken = $token; //'LtBcduSnJkTBJPqrWj2Bzhxx94sdtzDmoc8hODf7f9s';
        $this->administrationId = $adminId; // '347325906349458676';
        $this->apiBaseUrl = 
        'https://moneybird.com/api/v2/' . $this->administrationId .'/';
        $this->client = new MoneyBirdClient($this->apiToken);
        $this->client->apiBaseUrl = $this->apiBaseUrl;

        // $this->apiSubUrl = 'sales_invoices';

    }

    function MoneybirdSkeleton(string $command, string $method = 'GET', ?array $data = []  ) {

        // $cdata = json_encode($data);

        $response = $this->client->api($command, $method, $data);
        $objects = [];
        foreach($response as $array)
        {
            // $objects[] = $this->parse($array);
            $objects[] = $array;
        }
        return $objects;
        
    }
    private function createFilter($filter = array())
    {
        if($filter) {
            $stringFilter = [];
            foreach($filter as $key => $value)
            {
                $stringFilter[] = "$key:$value";
            }
            return implode(',', $stringFilter);
        }
        return [];
    }
    function GetInfo($haystack, $field)
    {
        if(isset($haystack[$field])) return $haystack[$field];
        return null;
    }

// CONTACTS https://developer.moneybird.com/api/contacts/
    function ListContacts( $filter = [] ) {
        $params = $this->createFilter($filter);
        $output = $this->MoneybirdSkeleton('contacts', 'GET', $params);
        return $output;
    }
    function CreateContact( $contact_name, $contacts ) {

        $contacts = array_merge(['company_name' => $contact_name], $contacts);
        $data = [
          "contact"=> $contacts,
          // "create_event" => false
        ];
        // var_dump($data, json_encode($data));
        $output = $this->MoneybirdSkeleton('contacts', 'POST', $data );
        return $output;
    }
    function GetContact( $id ) {
        $output = $this->MoneybirdSkeleton('contacts/customer_id/' . $id, 'GET');
        return $output;
    }
    function EditContact( $id, $contacts) {
        $data = [
            "contact"=> $contacts,
        ];
        $output = $this->MoneybirdSkeleton('contacts/'.$id,'PATCH', $data );
        return $output;
    }
    function DeleteContact( $id ) {
        $output = $this->MoneybirdSkeleton('contacts/'.$id.'.json', 'DELETE', []);
        return $output;
    }
    function CreateContactPerson( $contact_id, $person ) {
        $dflts = [
        'contact_id' => 0, //	Integer	Required Should be a valid contact id.
        'firstname' => '', //	
        'lastname' => '', //	
        'phone' => '', //	
        'email' => '', //       Should be a valid email addresses.
        'department' => '', //      
        ];
        $data = [
        "contact_person" => $person,
        // "create_event" => false
        ];
        $output = $this->MoneybirdSkeleton('contacts/'.$contact_id.'/contact_people','POST',$data );
        return $output;
    }
// PRODUCTS https://developer.moneybird.com/api/products/
    function ListProducts( $filter = null ) {
        $params = $this->createFilter($filter);
        $output = $this->MoneybirdSkeleton('products', 'GET', $params);
        return $output;
    }
    function GetProduct( $id ) {
        $output = $this->MoneybirdSkeleton('products/' . $id, 'GET');
        return $output;
    }
    function GetProductByIdentifier( $identifier ) {
        $output = $this->MoneybirdSkeleton('products/identifier/'.$identifier, 'GET' );
        return $output;
    }
    function CreateProduct( array $product ) {
        $model = [
        'title' => '',	
        'description' => '',	
        'price' => 0.0, //Decimal	Required Both a decimal and a string ‘10,95’ are accepted.
        'document_style_id'=> 0, //	Integer	Should be a valid document style id.
        'ledger_account_id'=> 0, //	Integer	Required Should be a valid ledger account id.
        'tax_rate_id'=> 0, //	Integer	Should be a valid tax rate id.
        'workflow_id'=> 0, //	Integer	Should be a valid workflow id.
        'currency' => 'EUR',	// Required ISO three-character currency code, e.g. EUR or USD.
        'checkout_type' => '', // Can be product or subscription.
        'frequency_type' => '', // Can be day, week, month, quarter or year.
        'frequency'=> 1, //	Integer	Should be an integer >= 1.
        'product_type' => '', //Can be digital_service, service or product.
        'vat_rate_type' => '', // Can be standard or reduced.
        'max_amount_per_order'=> 0, //Integer	Should be an integer 0 <= n < 2.
        'identifier' => '', // Should be unique for the administration.
        'frequency_preset' => ''    
        ];

        $example = [
            "description" => "Geldvogel",
            "price" => "50,50",
            "tax_rate_id" => 328294840514119302,
            "ledger_account_id" => 328294840540333704
        ];

        $Product = [
            'product' => $product // $example
        ];
        $output = $this->MoneybirdSkeleton('products', 'POST', $Product);
        return $output;
    }
    function EditProduct( $id, $product ) {
        $Product = [
            'product' => $product // $example
        ];
        $output = $this->MoneybirdSkeleton('products/'.$id, 'PATCH', $Product );
        return $output;
    }
    function DeleteProduct( $id ) {
        $output = $this->MoneybirdSkeleton('products/'.$id, 'DELETE');
        return $output;
    }


// INVOICES https://developer.moneybird.com/api/sales_invoices/
    /**
     * @param array $filter the filter to use, e.g. ['period' => 'this_month']
     * @return array the list of objects retrieved
     */
    public function ListInvoices($filter = array())
    {
        $params = $this->createFilter($filter);
        $output = $this->MoneybirdSkeleton('sales_invoices', 'GET', $params);
        return $output;
        // var_dump($response);
        // $objects = [];
        // foreach($response as $array)
        // {
        //     // $objects[] = $this->converter->parse($array);
        //     $objects[] = $this->parseInvoice($array);
        // }
        // return $objects;
    }
    function CreateInvoice( array $invoice ) {
        $model = 
        [
        'contact_id' => 0, //	Should be a valid contact id.
        'contact_person_id' => 0, //Should be a valid contact person id.
        'original_estimate_id' => 0, //	
        'document_style_id' => 0, // document style is used if value is not provided. Should be a valid document style id.
        'workflow_id' => 0, // If value is not provided, the workflow saved in the contact is used. If the contact doesn’t have a default workflow, the administration’s default workflow is used. Should be a valid workflow id.
        'reference' => '', //	
        'invoice_sequence_id' => '', //	
        'invoice_date' => '', //	
        'first_due_interval' => 0, //	
        'currency' => 'EUR', // ISO three-character currency code, e.g. EUR or USD.
        'prices_are_incl_tax'=> true, //	Boolean	
        'payment_conditions' => '', //	
        'discount'=> 0.0, //	Decimal	Discount percentage, e.g. 10,0%.
        'details_attributes' => [ //	
            ['id' => 0, //	
            'description' => '', //	
            'period' => '', //String with a date range: 20140101..20141231, presets are also allowed: this_month, prev_month, next_month, etc.
            'price' => 0.0, //	Decimal	Both a decimal and a string ‘10,95’ are accepted.
            'amount' => '', //	
            'tax_rate_id' => 0, //	Should be a valid tax rate id.
            'ledger_account_id' => 0, //Should be a valid ledger account id.
            'project_id' => 0, // Should be a valid project id.
            'product_id' => 0, // Should be a valid product id.
            'time_entry_ids'=> [], //	Array	
            'row_order' => 0, //	
            '_destroy' =>false, //	Boolean	
            'automated_tax_enabled'=> false, //	Boolean	
            'id' => 0, // Required
            ]
        ],

        'custom_fields_attributes'=> [
            [
            'id' => 0, //	Required
            'value' => '', //	Required
            ]
        ],
        'from_checkout' => false //	Boolean	
        ];

        $example = [
            "reference"=>"30052",
            "contact_id"=>337998612379207176,
            "currency"=>"USD",
            "details_attributes"=>
            [
            [
                "description"=>"Rocking Chair",
                "price"=>159.99,
                "tax_rate_id"=>337998612673857043
            ]
            ]
        ];

        $Invoice = [
            'sales_invoice' => $invoice // $example
        ];

        $output = $this->MoneybirdSkeleton('sales_invoices', 'POST', $Invoice );
        return $output;
    }
    function GetInvoice( $id ) {
        $output = $this->MoneybirdSkeleton('sales_invoices/'.$id, 'GET' );
        return $output;
    }
    function EditInvoice( $id, $invoice ) {
        $Invoice = [
            'sales_invoice' => $invoice // $example
        ];
        $output = $this->MoneybirdSkeleton('sales_invoices/'.$id, 'PATCH', $Invoice);
        return $output;
    }
    function DeleteInvoice( $id ) {
        $output = $this->MoneybirdSkeleton('sales_invoices/'.$id, 'DELETE');
        return $output;
    }
    function CreateInvoicePayment($sales_invoice_id, $payment) {

        $model_for_payment = [
            'invoice_id' => '',     //Required Integer 
            'payment_date' => '',   //Required string 2022-04-12 10:43:24 UTC
            'price' => '0.0',       //Required decimal "363.0" Both a decimal and a string ‘10,95’ are accepted. Should be a number -1,000,000,000 <= n <= 1,000,000,000.

            'price_base' => '0.0', // Amount paid expressed in the base currency. Required for foreign currencies. Should be a number -1,000,000,000 <= n <= 1,000,000,000.
            'financial_account_id' => '', //Integer: Should be a valid financial account id.
            'financial_mutation_id' => '', //Integer: Should be a valid financial mutation id.  
            'transaction_identifier' => '', //String
            'manual_payment_action' => '', //String Can be private_payment, payment_without_proof, cash_payment, rounding_error, bank_transfer, balance_settlement or invoices_settlement.
            'ledger_account_id' => '', //Integer Should be a valid ledger account id
        ];

//  curl -s -H "Content-Type: application/json" -H "Authorization: Bearer 84ec207ad0154a508f798e615a998ac1fd752926d00f955fb1df3e144cba44ab" \
//   -XPOST \
//   -d '{"payment":{"payment_date":"2022-04-12 10:43:24 UTC","price":"363.0"}}' \
//   https://moneybird.com/api/v2/123/sales_invoices/351838417511777364/payments.json

        $payment['invoice_id'] = $sales_invoice_id;
        $data = [
            'payment' => $payment
        ];

        $output = $this->MoneybirdSkeleton('sales_invoices/'.$sales_invoice_id.'/payments', 'POST', $data);
        return $output;
    }
// Send invoice PATCH /sales_invoices/:id/send_invoice(.:format)
    function SendInvoice( $sales_invoice_id, $sales_invoice_sending ) {

        // $sales_invoice_sending['delivery_method'] = Can be Email, Simplerinvoicing, Post or Manual.
        // $sales_invoice_sending['sending_scheduled'] = true/ false
        // $sales_invoice_sending['deliver_ubl'] = true/ false
        // $sales_invoice_sending['mergeable'] = true/ false
        // $sales_invoice_sending['email_address'] = string
        // $sales_invoice_sending['email_message'] = string
        // $sales_invoice_sending['invoice_date'] = string

        // curl -s -H "Content-Type: application/json" -H "Authorization: Bearer 84ec207ad0154a508f798e615a998ac1fd752926d00f955fb1df3e144cba44ab" \
        // -XPATCH \
        // -d '{"sales_invoice_sending":{"delivery_method":"Email","email_address":"alternative@example.com","email_message":"Hi, this is my invoice with id {invoice_id}!"}}' \
        // https://moneybird.com/api/v2/123/sales_invoices/351838413223102452/send_invoice.json

        $data = [
            'sales_invoice_sending' => $sales_invoice_sending
        ];
        $output = $this->MoneybirdSkeleton('sales_invoices/'.$sales_invoice_id.'/send_invoice', 'PATCH', $data);
        return $output;
// It returns
// "total_paid": "0.0",
// "total_unpaid": "363.0",
// "total_unpaid_base": "363.0",
// "url": "http://moneybird.dev/123/sales_invoices/c8f57928aa45c1a7823dd473063afa552c7dd725deaaa19d4f6f32e3fd15dbda/15a33ac2c0a5a959176c7760baa4d136d6ed5b362d60371b792e439c2ec12bbb",

// "payment_url": "http://moneybird.dev/123/online_sales_invoices/c8f57928aa45c1a7823dd473063afa552c7dd725deaaa19d4f6f32e3fd15dbda/15a33ac2c0a5a959176c7760baa4d136d6ed5b362d60371b792e439c2ec12bbb/pay_invoice",

    }

// LEDGER ACCOUNTS
    function GetAllLedgerAccounts() {
        $output = $this->MoneybirdSkeleton('ledger_accounts', 'GET' );
        return $output;
    }
    function GetLedgerAccount( $id ) {
        $output = $this->MoneybirdSkeleton('ledger_accounts/'.$id, 'GET' );
    return $output;
    }
    function CreateLedgerAccount( array $account ) {
        $model =
        [
        'name' => '', //Required Should be unique for this combination of administration and account type.
        'account_type' => '', //Required Can be non_current_assets, current_assets, equity, provisions, non_current_liabilities, current_liabilities, revenue, direct_costs, expenses or other_income_expenses.
        'account_id' => '', //Optional field, also known as general ledger code. Should be unique.
        'parent_id'=> 0, //	Integer	Id of the parent ledger account. Should be a valid ledger account id.
        'allowed_document_types' => [], //	Array	Can be sales_invoice, purchase_invoice, general_journal_document, financial_mutation or payment.
        ];

        $example = [
            "name" =>"Test ledger account",
            "account_type"=>"expenses",
            "account_id"=> 2182
        ];

        $Account = [
            'ledger_account' => $account // $example
        ];

        $output = $this->MoneybirdSkeleton('ledger_accounts', 'POST', $Account);
        return $output;
    }
    function EditLedgerAccount($id, array $account ) {
        $Account = [
            'ledger_account' => $account // $example
        ];
        $output = $this->MoneybirdSkeleton('ledger_accounts/'.$id, 'PATCH', $Account );
        return $output;
    }
    function DeleteLedgerAccount( $id ) {
        $output = $this->MoneybirdSkeleton('ledger_accounts/'.$id, 'DELETE' );
        return $output;
    }
// ------ utilities ------------- 
    public function parseInvoice(array $array)
    {
        $salesInvoice = new SalesInvoice();
        $salesInvoice->id = $array['id'];
        $salesInvoice->contactId = $array['contact_id'];
        // $salesInvoice->contact = new Ob(new Contact\ContactConverter())->parse($array['contact']);
        $salesInvoice->invoiceId = $array['invoice_id'];
        $salesInvoice->workflowId = $array['workflow_id'];
        $salesInvoice->documentStyleId = $array['document_style_id'];
        $salesInvoice->identityId = $array['identity_id'];
        $salesInvoice->state = $array['state'];
        $salesInvoice->invoiceDate = $array['invoice_date'];
        $salesInvoice->dueDate = $array['due_date'];
        $salesInvoice->paymentConditions = $array['payment_conditions'];
        $salesInvoice->reference = $array['reference'];
        $salesInvoice->language = $array['language'];
        $salesInvoice->currency = $array['currency'];
        $salesInvoice->discount = $array['discount'];
        $salesInvoice->originalSalesInvoiceId = $array['original_sales_invoice_id'];
        $salesInvoice->paidAt = $array['paid_at'];
        $salesInvoice->sentAt = $array['sent_at'];
        $salesInvoice->createdAt = $array['created_at'];
        $salesInvoice->updatedAt = $array['updated_at'];
        foreach($array['details'] as $lineArray)
        {
            $salesInvoice->lines[] = $lineArray;
            // $salesInvoice->lines[] = (new SalesInvoiceLineConverter())->parse($lineArray);
        }
        $salesInvoice->totalPaid = $array['total_paid'];
        $salesInvoice->totalUnpaid = $array['total_unpaid'];
        $salesInvoice->totalPriceExclTax = $array['total_price_excl_tax'];
        $salesInvoice->totalPriceExclTaxBase = $array['total_price_excl_tax_base'];
        $salesInvoice->totalPriceInclTax = $array['total_price_incl_tax'];
        $salesInvoice->totalPriceInclTaxBase = $array['total_price_incl_tax_base'];
        $salesInvoice->url = $array['url'];
        return $salesInvoice;
    }    
    
}

class SalesInvoice
{
    /**
     * @var object Contact\Contact
     */
    public $contact;
    /**
     * @var integer the identifier of the contact, i.e. 139326370847130628
     */
    public $contactId;
    /**
     * @var string the date on which the invoice was created, i.e. "2015-11-10T13:32:50.311Z"
     */
    public $createdAt;
    /**
     * @var string the currency code, i.e. "EUR"
     */
    public $currency;
    /**
     * @var string the discount, i.e. "0.0"
     */
    public $discount;
    /**
     * @var integer the identifier of the document style, i.e. 139326003435537520
     */
    public $documentStyleId;
    /**
     * @var string the date on which the invoice is due, i.e. "2015-11-24"
     */
    public $dueDate;
    /**
     * @var integer the identifier, for example 139326370910045191
     */
    public $id;
    /**
     * @var integer the identifier of the identity, i.e. 139326003178636389
     */
    public $identityId;
    /**
     * @var string the invoice number, i.e. "2015-0001"
     */
    public $invoiceId;
    /**
     * @var string the date of the invoice, i.e. "2015-11-10"
     */
    public $invoiceDate;
    /**
     * @var SalesInvoiceLine[] the lines of the sales invoice
     */
    public $lines = [];
    /**
     * @var string the language of the invoice, i.e. "nl"
     */
    public $language;
    /**
     * @var integer the original sales invoice identifier, in the case of a credit invoice, i.e. 139400223322539015
     */
    public $originalSalesInvoiceId;
    /**
     * @var string the date on which the invoice was paid
     */
    public $paidAt;
    /**
     * @var string the description of the payment conditions, i.e. "We verzoeken u vriendelijk het bovenstaande bedrag
     * van {document.total_price} voor {document.due_date} te voldoen op onze bankrekening onder vermelding van het
     * factuurnummer {document.invoice_id}. Voor vragen kunt u contact opnemen per e-mail."
     */
    public $paymentConditions;
    /**
     * @var string the description of the reference, i.e. "Project X"
     */
    public $reference;
    /**
     * @var string the date on which the invoice was sent, i.e. "2015-11-10"
     */
    public $sentAt;
    /**
     * @var string the status of the invoice, i.e. "open"
     */
    public $state;
    /**
     * @var string the total amount paid, i.e. "0.0"
     */
    public $totalPaid;
    /**
     * @var string the total price excluding tax, i.e. "300.0"
     */
    public $totalPriceExclTax;
    /**
     * @var string the total price excluding tax, base rate, i.e. "300.0"
     */
    public $totalPriceExclTaxBase;
    /**
     * @var string the total price including tax, i.e. "363.0"
     */
    public $totalPriceInclTax;
    /**
     * @var string the total price including tax, base rate, i.e. "363.0"
     */
    public $totalPriceInclTaxBase;
    /**
     * @var string the total amount unpaid, i.e. "363.0"
     */
    public $totalUnpaid;
    /**
     * @var string the date and time on which the invoice was last updated, i.e. "2015-11-10T13:32:50.478Z"
     */
    public $updatedAt;
    /**
     * @var string the location on which the sales invoice can be found
     */
    public $url;
    /**
     * @var integer the identifier of the workflow, i.e. 139326003273008230
     */
    public $workflowId;

    /**
     * @return \DateTime the due date as a DateTime object
     */
    public function getDueDateTime()
    {
        return \DateTime::createFromFormat('Y-m-d', $this->dueDate);
    }

    /**
     * @return \DateTime the invoice date as a DateTime object
     */
    public function getInvoiceDateTime()
    {
        return \DateTime::createFromFormat('Y-m-d', $this->invoiceDate);
    }

}