<?php

class Moneybird {
    private $settings;
    private $access_token;
    private $InvoiceData;
    private $authorization;

    function __construct(array $settings = [])
    {
        $fullScope = [
            'sales_invoices',
            'documents',
            'estimates',
            'bank',
            'time_entries',
            'settings'
        ];
        $this->settings = [
            'CLIENT_ID' => '123', // ??
            'ADMIN_ID' => '347325906349458676', // ??
            'CLIENT_SECRET' => '4321',
            'CALLBACK' => 'http://localhost:8000',
            'SCOPES' => ['sales_invoices', 'documents'],
        ];
        $this->settings += $settings;
        $this->format = '.json';
        // $this->authorization = "Bearer '84ec207ad0154a508f798e615a998ac1fd752926d00f955fb1df3e144cba44ab'";

        $this->access_token = 'LtBcduSnJkTBJPqrWj2Bzhxx94sdtzDmoc8hODf7f9s'; 
    }
    function SetSettings (array $settings = []) {
        $this->settings += $settings;
        return $this;
    }
    function authorizeUrl()
    {
      $pattern = "https://moneybird.com/oauth/authorize?client_id=%s&redirect_uri=%s&scope=%s&response_type=code";
      return sprintf($pattern, 
        $this->settings['CLIENT_ID'],
        urlencode($this->settings['CALLBACK']),
        implode("+", $this->settings['SCOPES']));
    }

    function getAccessCode($request_code) {
        $curl = curl_init("https://moneybird.com/oauth/token");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, rawurldecode(http_build_query(array(
          'client_id' => $this->settings['CLIENT_ID'],
          'redirect_uri' => $this->settings['CALLBACK'],
          'client_secret' => $this->settings['CLIENT_SECRET'],
          'code' => $request_code,
          'grant_type' => 'authorization_code'
        ))));
      
        $json = json_decode(curl_exec($curl));
        $this->access_token = $json->access_token; 
        
        // $this->access_token = 'lTtsK0t8e7UTSwDC6fwUbG4ycuNC0OJUmw7IUyuToRs'; 
        $this->access_token = 'LtBcduSnJkTBJPqrWj2Bzhxx94sdtzDmoc8hODf7f9s'; 
        return $this->access_token;
      }    

  function getAdministrations() {
    $headers = array(
      'Content-Type: application/json',
      $this->authorization()
    );
  
    $curl = curl_init("https://moneybird.com/api/v2/administrations.json");
  
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
    $result = json_decode(curl_exec($curl));
  
    return $result;
  }    

  // CONTACTS https://developer.moneybird.com/api/contacts/
  function CreateContact( $contact_name, $contacts ) {
    $dflts = [
      'company_name' =>'', //A contact requires a non-blank company_name, firstname or lastname.
      'address1' => '',	
      'address2' => '',	
      'zipcode' => '',	
      'city' => '',	
      'country' => '',	// ISO two-character country code, e.g. NL or DE.
      'phone' => '',	
      'delivery_method' => '',	// Can be Email, Simplerinvoicing, Post or Manual.
      'customer_id' => '',	// Will be assigned automatically if empty. Should be unique for the administration.
      'tax_number' => '',	
      'firstname' => '',	//A contact requires a non-blank company_name, firstname or lastname.
      'lastname' => '',	// A contact requires a non-blank company_name, firstname or lastname.
      'chamber_of_commerce' => '',	
      'bank_account' => '',	
      'send_invoices_to_attention' => '',	
      'send_invoices_to_email' => '',	//       Should be one or more valid email addresses, separated by a comma.
      'send_estimates_to_attention' => '',	
      'send_estimates_to_email' => '', // Should be one or more valid email addresses, separated by a comma.
      'sepa_active'=> false, //      When true, all other SEPA fields are required.
      'sepa_iban' => '',	//      Should be a valid IBAN.
      'sepa_iban_account_name' => '',	
      'sepa_bic' => '',	//      Should be a valid BIC.
      'sepa_mandate_id' => '',	
      'sepa_mandate_date' => '', // Should be a date in the past.
      'sepa_sequence_type' => '',	// Can be RCUR, FRST, OOFF or FNAL.
      'si_identifier_type' => '',	//       Can be 0002, 0007, 0009, 0037, 0060, 0088, 0096, 0097, 0106, 0130, 0135, 0142, 0151, 0183, 0184, 0190, 0191, 0192, 0193, 0195, 0196, 0198, 0199, 0200, 0201, 0202, 0204, 0208, 0209, 9901, 9906, 9907, 9910, 9913, 9914, 9915, 9918, 9919, 9920, 9922, 9923, 9924, 9925, 9926, 9927, 9928, 9929, 9930, 9931, 9932, 9933, 9934, 9935, 9936, 9937, 9938, 9939, 9940, 9941, 9942, 9943, 9944, 9945, 9946, 9947, 9948, 9949, 9950, 9951, 9952, 9953, 9955 or 9957.
      'si_identifier' => '',	
      'invoice_workflow_id'=> 0, //	Integer:	Should be a valid invoice workflow id.
      'estimate_workflow_id'=>0, //	Integer	Should be a valid estimate workflow id.
      'email_ubl'=> false, //	Boolean	
      'direct_debit'=> false, // Boolean	
      'custom_fields_attributes[id]'=> 0, //Integer: Required
      'custom_fields_attributes[value]' => '', // Required
      // '{"contact":{"company_name":"Test B.V.","custom_fields_attributes":{"0":{"id":340087756248057027,"value":"Field value"}}}}'
    ];
    // create_event	Boolean	

    $contacts = array_merge(['company_name' => $contact_name], $contacts);
    $data = [
      "contact"=> $contacts,
      // "create_event" => false
    ];

    var_dump($data, json_encode($data));

    $output = $this->MoneybirdCommandSkeleton('contacts.json', $data, 'POST' );
    return $output;
  }

  function GetContact( $id ) {
    $output = $this->MoneybirdCommandSkeleton('contacts/customer_id/'.$id.'.json', null, 'GET' );
    return $output;
  }
  function EditContact( $id, $contacts) {
    $data = [
      "contact"=> $contacts,
    ];
    $output = $this->MoneybirdCommandSkeleton('contacts/'.$id.'.json', $data, 'PATCH' );
    return $output;
  }
  function DeleteContact( $id ) {
    $output = $this->MoneybirdCommandSkeleton('contacts/'.$id.'.json', [], 'DELETE' );
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
      "contact_person"=> $person,
      // "create_event" => false
    ];
    $output = $this->MoneybirdCommandSkeleton('contacts/'.$contact_id.'/contact_people.json', $data, 'POST' );
    return $output;

 }

// PRODUCTS https://developer.moneybird.com/api/products/
  function GetAllProducts($params = null) {
    $tail = '';
    if($params) {
      if(isset($params['query'])) $tail .= "?query=" . $params['query']; // filtering by product name
      if(isset($params['page'])) $tail .= "?page=" . $params['page']; // The page to fetch, starting at 1.
      if(isset($params['currency'])) $tail .= "?currency=" . $params['currency']; // ISO three-character currency code, e.g. EUR or USD.
    }
    $output = $this->MoneybirdCommandSkeleton('products.json' . $tail, null, 'GET' );
    return $output;
  }
  function GetProductById( $id ) {
    $output = $this->MoneybirdCommandSkeleton('products/'.$id.'.json', null, 'GET' );
    return $output;
  }
  function GetProductByIdentifier( $identifier ) {
    $output = $this->MoneybirdCommandSkeleton('products/identifier/'.$identifier.'.json', null, 'GET' );
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
      "description"=>"Geldvogel",
      "price"=>"50,50",
      "tax_rate_id"=>328294840514119302,
      "ledger_account_id"=>328294840540333704
    ];

    $Product = [
      'product' => $product // $example
    ];
    $output = $this->MoneybirdCommandSkeleton('products.json', $Product, 'POST' );
    return $output;
  }
  function EditProduct( $id, $product ) {
    $Product = [
      'product' => $product // $example
    ];
    $output = $this->MoneybirdCommandSkeleton('products/'.$id.'.json', $Product, 'PATCH' );
    return $output;
  }
  function DeleteProduct( $id ) {
    $output = $this->MoneybirdCommandSkeleton('products/'.$id.'.json', [], 'DELETE' );
    return $output;
  }

// LEDGER ACCOUNTS
  function GetAllLedgerAccounts() {
    $output = $this->MoneybirdCommandSkeleton('ledger_accounts.json', null, 'GET' );
    return $output;
  }
  function GetLedgerAccount( $id ) {
    $output = $this->MoneybirdCommandSkeleton('ledger_accounts/'.$id.'.json', null, 'GET' );
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

    $output = $this->MoneybirdCommandSkeleton('ledger_accounts.json', $Account, 'POST' );
    return $output;

  }
  function EditLedgerAccount($id, array $account ) {

    $Account = [
      'ledger_account' => $account // $example
    ];
    $output = $this->MoneybirdCommandSkeleton('ledger_accounts/'.$id.'.json', $Account, 'PATCH' );
    return $output;
  }
  function DeleteLedgerAccount( $id ) {
    $output = $this->MoneybirdCommandSkeleton('ledger_accounts/'.$id.'.json', [], 'DELETE' );
    return $output;
  }

// INVOICES https://developer.moneybird.com/api/sales_invoices/
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

    $output = $this->MoneybirdCommandSkeleton('sales_invoices.json', $Invoice, 'POST' );
    return $output;
  }

// ===========================
  function MoneybirdCommandSkeleton(string $command, ?array $data = [], string $method = 'POST' ) : string {

    $cdata = json_encode($data);


    // var_dump( $cdata );
    $cdata = '{"contact":{"company_name":"Test B.V.","custom_fields_attributes":{"0":{"id":340087756248057027,"value":"Field value"}}}}';

    $exec_command = 
    'curl -s -H "Content-Type: application/json" -H "'
    . $this->authorization()
    . '" -X' . $method;

    // var_dump( $exec_command );

    $exec_command .= 
    $data === null ? '' : " -d '" . $cdata . "' " 
    . $this->MoneybirdClient() 
    . $command;

    var_dump( $exec_command );

    $output = json_decode(shell_exec($exec_command));
    var_dump($output);

    return $output;
  }
  function authorization() : string {
    return "Authorization: Bearer " . $this->access_token;
  }
  function MoneybirdClient() : string {
    return 'https://moneybird.com/api/v2/'. $this->settings['ADMIN_ID'].'/';
  }

  // Service functions ===============
  function getInvoiceData() : string {
    return json_encode($this->InvoiceData);
  }
  function setInvoiceData(array $InvoiceData) {
    $product_list = [
      ['description' => 'Rocking Chair', 'price' => 10, 'tax_rate_id' => '' ],
      ['description' => 'Rocking Chair', 'price' => 20, 'tax_rate_id' => '' ],
    ];
    $this->InvoiceData = [
      'reference' => '', // "30052" 
      'contact_id' => '', // "337998612379207176" 
      'currency' => 'EUR', // "USD" 
      'details_attributes' => $product_list, // "30052" 
    ];

    return $this->InvoiceData;
  }


  // example ============== 
  function WorkFlow() {
    session_start();

    if (isset($_GET['reset'])) {
        session_destroy();
        header(sprintf("Location: %s", $this->settings['CALLBACK']));
        die();
      } elseif(isset($_SESSION['access_token'])) {
        $administrations = $this->getAdministrations($_SESSION['access_token']);
      
        foreach($administrations as $administration) {
          echo $administration->name . "<br />";
        }
      } elseif (isset($_GET['code'])) {
        $access_token = $this->getAccessCode($_GET['code']);
        $_SESSION['access_token'] = $access_token;
      
        header(sprintf("Location: %s", $this->settings['CALLBACK']));
        die();
      }  else {
        echo "Starting point, click on the link <br />"
        ?>
        <a href="<?php echo $this->authorizeUrl(); ?>">Click</a>
        <?php
      }    
  }
// From account bulat_baltin@rambler.ru / bulat_****
// https://moneybird.com/347324289162151147/sales_invoices/filter/period:this_year
// https://moneybird.com/347325906349458676/sales_invoices/new?minicoach_subgoal_id=347325927528597397

//https://moneybird.com/347325906349458676/open_goals/347325927458342798

// My Moneybird token
// LtBcduSnJkTBJPqrWj2Bzhxx94sdtzDmoc8hODf7f9s
// Authorization: Bearer LtBcduSnJkTBJPqrWj2Bzhxx94sdtzDmoc8hODf7f9s

// Paths
// The Moneybird API resides on the following paths:

// https://moneybird.com/api/:version/:administration_id/:resource_path.:format
// The :version part of the path indicates the version of the API you want to use. At this moment version v2 is the only available version. By pointing to a specific version, we can make sure you always can expect equal behaviour from our API.
// The :administration_id part indicates the administration you want to access. This id corresponds with the id you see in the path when you are accessing the administration via our web application.
// The :resource_path part indicates the path of the resource you want to access. Specific paths to resources can be found in the API documentation. Examples of resource paths are: /contacts to retrieve all contacts or /contacts/:id/notes to create new note for a contact.
// The :format part indicates the format in which you want to transport data. Currently two formats are supported: json and xml.


}
?>