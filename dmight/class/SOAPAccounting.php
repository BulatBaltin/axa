<?php

// namespace App\Service;

// use DateTime;
// use SoapClient;
// use SoapFault;

class SOAPAccounting
{
    private $client;
    private $apiClient;
    private $session_id;
    private $login;
    private $key1;
    private $key2;

    public function __construct(string $login = null, string $SecurityKey1 = null, string $SecurityKey2 = null, string $apiClient = null)
    {
        // https://secure.e-boekhouden.nl/handleiding/Documentation_soap_english.pdf
        // API login
        // Gebruikersnaam: trompittest
        // Beveiligingscode 1: 3b9154c547291e567d8aad69ee6eef12
        // Beveiligingscode 2: 4144FACD-12AA-49CF-ADD9-B052D94CC8A7

        // URL: http:// soap.trompitservice.nl /soap.php
        // Username: apiusr
        // Code 1: bbnvmrt34wsqp9065gnm
        // Code 2: vbmnplzbn45qwplhgkl

        // $this->apiClient = $apiClient === null ? 'https://soap.e-boekhouden.nl/soap.asmx?WSDL' : $apiClient;
        // $this->login = $login === null ? 'trompittest' : $login;
        // $this->key1 = $SecurityKey1 === null ? '3b9154c547291e567d8aad69ee6eef12' : $SecurityKey1;
        // $this->key2 = $SecurityKey2 === null ? '4144FACD-12AA-49CF-ADD9-B052D94CC8A7' : $SecurityKey2;

        $this->apiClient = $apiClient === null ? 'https://soap.trompitservice.nl?wsdl' : $apiClient;
        $this->login = $login === null ? 'apiusr' : $login;
        $this->key1 = $SecurityKey1 === null ? 'bbnvmrt34wsqp9065gnm' : $SecurityKey1;
        $this->key2 = $SecurityKey2 === null ? 'vbmnplzbn45qwplhgkl3' : $SecurityKey2;

        $this->session_id = $this->OpenSession();
    }

    public function getSessionId()
    {
        return $this->session_id;
    }
    public function OpenSession()
    {
        try {
            $this->client = new SoapClient($this->apiClient, ["trace" => 1]);
            // open session and get sessionID
            $params = array(
                "Username" => $this->login,
                "SecurityCode1" => $this->key1,
                "SecurityCode2" => $this->key2
            );

            $response = $this->client->__soapCall("OpenSession", array($params));
            $this->checkforerror($response, "OpenSessionResult");
            $SessionID = $response->OpenSessionResult->SessionID;
        } catch (SoapFault $soapFault) {
            echo $soapFault;
        }

        $this->session_id = $SessionID;

        return $SessionID;
    }

    /// + ------------------- AddRelatie ---------------- +
    function getRelationFields()
    {
        $fields = [
            'ID' => 0, // id
            'AddDatum' => strtotime(date("Y-m-d H:i:s")), // Add date
            'Code' => '', //* S(15)
            'Bedrijf' => '', //* S(100) // Company name
            'Contactpersoon' => '', // S(150) Contact person
            'Geslacht' => '', // S(1) Gender m / v
            'Adres' => '', // S(150) Company address
            'Postcode' => '', // S(50) Zip code
            'Plaats' => '', // S(50) Place
            'Land' => '', // S(50) Country
            'Adres2' => '', // S(150) Postal address
            'Postcode2' => '', // S(50) Zip code
            'Plaats2' => '', // S(50) Place
            'Land2' => '', // S(50) Country
            'Telefoon' => '', // S(50) Phone number
            'GSM' => '', // S(50) Cell Phone number
            'FAX' => '', // S(50) Fax number
            'Email' => '', // S(150) Email
            'Site' => '', // S(50) Web-site
            'Notitie' => '', // S(Max) Note
            'Bankrekening' => '', // S(50) Bank account
            'Girorekening' => '', // S(50) Giro account Deprecated, use IBAN.
            'BTWNummer' => '', // S(50) VAT number
            'Aanhef' => '', // S(50) Preamble
            'IBAN' => '', // S(50) IBAN
            'BIC' => '', // S(50) BIC
            'BP' => '', // S(1) Business or private B/P
            'Def1' => '', // S(100) User defined
            'Def2' => '', // S(100) User defined
            'Def3' => '', // S(100) User defined
            'Def4' => '', // S(100) User defined
            'Def5' => '', // S(100) User defined
            'Def6' => '', // S(100) User defined
            'Def7' => '', // S(100) User defined
            'Def8' => '', // S(100) User defined
            'Def9' => '', // S(100) User defined
            'Def10' => '', // S(100) User defined
            'LA' => '0', // S(1) Members administration 0 / 1 
            'Gb_ID' => 0, // Int Ledger account ID  Error GB_ID
            'GeenEmail' => 0, // Int No email
            'NieuwsbriefgroepenCount' => 0, // Int NieuwsbriefGroepenCount(Error!) Newsletter group and count Reserved, not used
        ];
        return $fields;
    }

    function setRelationFields($fields)
    {
        // fixture mode
        $fields['Code'] = '0002';     // Client
        $fields['AddDatum'] = strtotime(date("Y-m-d H:i:s")); // Add date
        $fields['Bedrijf'] = 'Very usefull company(2)';

        return $fields;
    }

    public function AddRelation() // AddRelatie
    {
        $fields = $this->getRelationFields();
        $fields = $this->setRelationFields($fields);

        $params = [
            'SecurityCode2' => $this->key2,
            'SessionID' => $this->session_id,
            'oRel' => $fields
        ];
        $response = $this->client->__soapCall("AddRelatie", array($params));
        $this->checkforerror($response, "AddRelatieResult");
        return $response;
    }
    public function UpdateRelation() // UpdateRelatie
    {
        $fields = $this->getRelationFields();
        $fields = $this->setRelationFields($fields);

        $params = [
            'SecurityCode2' => $this->key2,
            'SessionID' => $this->session_id,
            'oRel' => $fields
        ];
        $response = $this->client->__soapCall("UpdateRelatie", array($params));
        $this->checkforerror($response, "UpdateRelatieResult");
        return $response;
    }

    public function GetRelations() // GetRelaties
    {
        $filter = [
            // 'Trefwoord' => '', // Keyword
            // 'Code' => '',
            'ID' => 0
        ];

        $params = array(
            "SecurityCode2" => $this->key2,
            "SessionID" => $this->session_id,
            "cFilter" => $filter
        );
        $response = $this->client->__soapCall("GetRelaties", array($params));
        // $this->checkforerror($response, "GetRelatiesResult");

        return $response;
    }
    /// + ------------------- end AddRelatie -------------- +
    /// + ------------------- Artikelen ------------------- +
    function getArtikelFields()
    {
        $fields = [
            'ArtikelID' => 0, // Unique number per Product
            'ArtikelOmschrijving' => '', // S(Max) Description of Product
            'Artikelcode' => '', //S(20) Code of Product
            'GroepOmschrijving' => '', // Description of Productgroup
            'Groepcode' => '', // Code of Productgroup
            'Eenheid' => '', // Unit of Product
            'InkoopprijsExclBtw' => 0, // Purchase price excl. VAT
            'VerkoopprijsExclBtw' => 0, // Sellingprice excl. VAT
            'VerkoopprijsInclBtw' => 0, // Sellingprice incl. VAT
            'Btw-code' => '', // VAT code of Product
            'Tegenrekeningcode' => '', //> Ledger number
            'BTW percentage' => '', //> VAT rate of Product
            'Kostenplaats' => '', // Cost center of Product
            'Actief' => true // Is the product active in e-Boekhouden.nl?
        ];

        return $fields;
    }
    //
    public function GetArtikelen()
    {
        $filter = [
            'ArtikelID' => 0, // Int N Product ID 
            'ArtikelOmschrijving' => '', // String N Max Product description
            'ArtikelCode' => '', // String N 20 Product code 
            'GroepOmschrijving' => '', // String N 50 Group description 
            'GroepCode' => '', // String N 50 Group code
            'Eenheid' => '', // String N 50 Group code
            
            'VerkoopprijsExclBTW' => '', // rate  
            'VerkoopprijsInclBTW' => '', // ratevat  
            'BTWCode' => 'HOOG_VERK_21', // taxcode  
            'TegenrekeningCode' => '8020', // Counter Account
            'BtwPercentage' => '', // taxrate "0.21"  
            'Actief' => '', // "0.21"  
        ];

// ArtikelID": 3431202
//           +"ArtikelOmschrijving": "DIverse werkzaamheden"
//           +"ArtikelCode": "TISP"
//           +"GroepOmschrijving": ""
//           +"GroepCode": ""
//           +"Eenheid": "uur"
//           +"InkoopprijsExclBTW": "0"
//           +"VerkoopprijsExclBTW": "42"
//           +"VerkoopprijsInclBTW": "50.82"
//           +"BTWCode": "HOOG_VERK_21"
//           +"TegenrekeningCode": "8020"
//           +"BtwPercentage": "0.21"
//           +"KostenplaatsID": 0
//           +"Actief": true



        $params = array(
            "SecurityCode2" => $this->key2,
            "SessionID" => $this->session_id,
            "cFilter" => $filter
        );
        $response = $this->client->__soapCall("GetArtikelen", array($params));
        // $this->checkforerror($response, "GetRelatiesResult");

        return $response;

        // <ArtikelID> Unique number per Product
        // <ArtikelOmschrijving> Description of Product
        // <Artikelcode> Code of Product
        // <GroepOmschrijving> Description of Productgroup
        // <Groepcode> Code of Productgroup
        // <Eenheid> Unit of Product
        // <Inkoopprijs Excl btw> Purchase price excl. VAT
        // <Verkoopprijs Excl btw> Sellingprice excl. VAT
        // <Verkoopprijs Incl btw> Sellingprice incl. VAT
        // <Btw-code> VAT code of Product
        // <Tegenrekeningcode> Ledger number
        // <BTW percentage> VAT rate of Product
        // <Kostenplaats> Cost center of Product
        // <Actief> Is the product active in e-Boekhouden.nl?
    }
    /// + ------------------- end Artikelen --------------- +
    /// + ------------------- Read invoice ---------------- +
    public function GetFacturen($StartDateUnix = null, $EndDateUnix = null, $InvoiceN = null, $Client = null)
    {
        // $StartDate = strtotime('2019-10-01'); // Unix time
        // $EndDate = strtotime('2019-11-30'); // Unix time
        $Filter = []; // "DatumVan" => $StartDate, "DatumTm" => $EndDate];

        if ($StartDateUnix) {
            $Filter["DatumVan"] = $StartDateUnix;
        } else {
            // $now = new DateTime();
            // $Filter["DatumVan"] = strtotime("first day of this month");
            // $Filter["DatumVan"] = 1573493989; //strtotime("first day of this year");
            $Filter["DatumVan"] = 1500000000; //strtotime("first day of this year");
        }
        if ($EndDateUnix) {
            $Filter["DatumTm"] = $EndDateUnix;
        } else {
            // $now = new DateTime();
            $Filter["DatumTm"] = strtotime("now");
        }
        if ($InvoiceN) {
            $Filter["Factuurnummer"] = $InvoiceN;
        }
        if ($Client) {
            $Filter["Relatiecode"] = $Client;
        }

        $params = array(
            "SecurityCode2" => $this->key2,
            "SessionID" => $this->session_id,
            "cFilter" => $Filter
        );

        $response = $this->client->__soapCall("GetFacturen", array($params));
        $this->checkforerror($response, "GetFacturenResult");
        return $response;
    }
    /// + ------------------- end of Read invoice --------- +

    /// + ------------------- Create invoice -------------- +
    public function getPlainFactuurFields(): array
    {
        $fields = [
            'Factuurnummer', //": "F00001"
            "Relatiecode", //: "0002"
            "Datum", //: "2019-10-28T00:00:00"
            "Betalingstermijn", //: 0
            "TotaalExclBTW", //: 19.5
            "TotaalBTW", //: 4.1
            "TotaalInclBTW", //: 23.6
            "TotaalOpenstaand", //: 23.6
            "URLPDFBestand" //: "https://secure.e-boekhouden.nl/bh/getfactuur.asp?c=266605-15660038-F00001&s=28697767145812298274"
        ];


        // $fields = $this->getFactuurFields();
        // $plain_fields = [];
        // foreach ($fields as $key => $val) {
        //     if (!\is_array($val)) {
        //         $plain_fields[] = $key;
        //     }
        // }

        return $fields;
    }
    public function getFactuurFields(): array
    {
        $fields = [
            'Factuurnummer' => '', // S(50) - No
            'Relatiecode' => '', //* S(15) Relation code (Partner, client) - Yes
            'Datum' => strtotime('2022-01-01'), //* D(1980 - 2049)
            'Betalingstermijn' => 14, // Int, Prompt, due date No
            'Factuursjabloon' => '', //* S(50), Invoice template
            'PerEmailVerzenden' => false, // Bool, Send by e-mail
            'EmailOnderwerp' => '', // S(Max), E-mail subject
            'EmailBericht' => '', // S(Max), E-mail body
            'EmailVanAdres' => '', // S(150), E-mail sender address
            'EmailVanNaam' => '', // S(150), E-mail sender name
            'AutomatischeIncasso' => false, // Bool, Direct debit
            'IncassoIBAN' => '', // S(150), Direct debit IBAN
            'IncassoMachtigingSoort' => '', // S(1), Direct debit authorization category
            // E: eenmalige machtiging (one-time authorization) D: doorlopende machtiging (continuous authorization)
            'IncassoMachtigingID' => '', // S(50), Direct debit authorization ID
            'IncassoMachtigingDatumOndertekening' => strtotime('2022-01-01'), // Date, Direct debit authorization signature date
            'IncassoMachtigingFirst' => false, // Bool, Direct debit authorization first
            'IncassoRekeningNummer' => '', // S(150), Direct debit account number
            'IncassoTnv' => '', // S(150), Direct debit att.
            'IncassoPlaats' => '', // S(150), Direct debit place
            'IncassoOmschrijvingRegel1' => '', // S(50), Direct debit description line 1
            'IncassoOmschrijvingRegel2' => '', // S(50), Direct debit description line 2
            'IncassoOmschrijvingRegel3' => '', // S(50), Direct debit description line 3
            'InBoekhoudingPlaatsen' => false, // Bool, In administration
            'BoekhoudmutatieOmschrijving' => '', // S(200), Administration transaction description
            'Regels' => //* Array, Lines
            [
                'cFactuurRegel' => [
                    [
                        'Aantal' => 1, // Double, number, If not specified: 0
                        'Eenheid' => '', // S(50), Unit, <empty>, Piece, Box, Hour
                        'Code' => '', //* S(50), Code
                        'Omschrijving' => '', //* S(Max), Description
                        'PrijsPerEenheid' => 0, // Double, Price per unit
                        'BTWCode' => '', //* S(12), VAT code
                        'TegenrekeningCode' => '', //* S(10), Counter account code
                        'KostenplaatsID' => 0 // Int, Cost centre ID
                    ],
                    [
                        'Aantal' => 1, // Double, number, If not specified: 0
                        'Eenheid' => '', // S(50), Unit, <empty>, Piece, Box, Hour
                        'Code' => '', //* S(50), Code
                        'Omschrijving' => '', //* S(Max), Description
                        'PrijsPerEenheid' => 0, // Double, Price per unit
                        'BTWCode' => '', //* S(12), VAT code
                        'TegenrekeningCode' => '', //* S(10), Counter account code
                        'KostenplaatsID' => 0 // Int, Cost centre ID                

                    ]
                ]
            ]
        ];

        return $fields;
    }
    public function getNewRow()
    {
        $row = [
            'Aantal' => 1, // Double, number, If not specified: 0
            'Eenheid' => '', // S(50), Unit, <empty>, Piece, Box, Hour
            'Code' => '', //* S(50), Code
            'Omschrijving' => '', //* S(Max), Description
            'PrijsPerEenheid' => 0, // Double, Price per unit
            'BTWCode' => '', //* S(12), VAT code
            'TegenrekeningCode' => '', //* S(10), Counter account code
            'KostenplaatsID' => 0 // Int, Cost centre ID                

        ];
        return $row;
    }

    function setFactuurHeader($fields)
    {
        // fixture mode
        $fields['Relatiecode'] = '0002';     // Client Very usefull (2)
        $fields['Datum'] = strtotime('2019-10-28');    // 
        $fields['Factuursjabloon'] = 'Factuursjabloon';
        $fields['IncassoRekeningNummer'] = '0001';
        return $fields;
    }
    function setFactuurRegels($fields)
    {
        $oneRow = $fields['Regels'][0]['cFactuurRegel'];
        $oneRow['Aantal'] = 3; // Amount
        $fields['Regels'][0]['cFactuurRegel']['PrijsPerEenheid'] = 100; // Price
        $fields['Regels'][0]['cFactuurRegel']['Code'] = '001';
        $fields['Regels'][0]['cFactuurRegel']['Omschrijving'] = 'Invoice automation: front-office';
        // BI_EU_VERK_D Diensten naar binnen de EU 0% // Services inside EU 0%
        $fields['Regels'][0]['cFactuurRegel']['BTWCode'] = 'BI_EU_VERK_D'; // VAT code
        $fields['Regels'][0]['cFactuurRegel']['TegenrekeningCode'] = '0002'; // Counter-account code
        // $fields['Regels'][0]['cFactuurRegel']['KostenplaatsID'] = '0001'; // Cost-center

        // Row-2
        $fields['Regels'][1]['cFactuurRegel']['Aantal'] = 1; // Amount
        $fields['Regels'][1]['cFactuurRegel']['PrijsPerEenheid'] = 150; // Price
        $fields['Regels'][1]['cFactuurRegel']['Code'] = '001';
        $fields['Regels'][1]['cFactuurRegel']['Omschrijving'] = 'Invoice automation: back-office';
        // BI_EU_VERK_D Diensten naar binnen de EU 0% // Services inside EU 0%
        $fields['Regels'][1]['cFactuurRegel']['BTWCode'] = 'BI_EU_VERK_D'; // VAT code
        $fields['Regels'][1]['cFactuurRegel']['TegenrekeningCode'] = '0001'; // Counter-account code
        // $fields['Regels'][0]['cFactuurRegel']['KostenplaatsID'] = '0001'; // Cost-center

        return $fields;
    }
    function setFactuurRegels2($fields)
    {
        // fixture mode
        // Row-1
        $oneRow = $fields['Regels']['cFactuurRegel'];

        $oneRow['Aantal'] = 3; // Amount
        $fields['Regels']['cFactuurRegel']['PrijsPerEenheid'] = 100; // Price
        $fields['Regels']['cFactuurRegel']['Code'] = '001';
        $fields['Regels']['cFactuurRegel']['Omschrijving'] = 'Invoice automation: front-office';
        // BI_EU_VERK_D Diensten naar binnen de EU 0% // Services inside EU 0%
        $fields['Regels']['cFactuurRegel']['BTWCode'] = 'BI_EU_VERK_D'; // VAT code
        $fields['Regels']['cFactuurRegel']['TegenrekeningCode'] = '0002'; // Counter-account code
        // $fields['Regels'][0]['cFactuurRegel']['KostenplaatsID'] = '0001'; // Cost-center

        return $fields;
    }
    public function AddFactuur($fields)
    {

        $params = [
            "SecurityCode2" => $this->key2,
            "SessionID" => $this->session_id,
            "oFact" => $fields
        ];
        $response = $this->client->__soapCall("AddFactuur", array($params));
        // $rawXml = $this->client->__getLastRequest();
        // $responseXml = $this->client->__getLastResponse(); //, $method, $service, $error);
        // dd($rawXml, $responseXml); //<DEV-MODE

        $this->checkforerror($response, "AddFactuurResult");
        return $response;
    }
    // + ------------------------- End of Facturen ---------------------- + //

    public function GetLedgerAccounts()
    {
        $params = array(
            "SecurityCode2" => $this->key2,
            "SessionID" => $this->session_id,
            'cFilter' => array(
                "ID" => 0,
                "Code" => "",
                "Categorie" => "BAL"
            )
        );
        $response = $this->client->__soapCall("GetGrootboekrekeningen", array($params));
        $this->checkforerror($response, "GetGrootboekrekeningenResult");
        $Accounts = $response->GetGrootboekrekeningenResult->Rekeningen;
        // if result, create array
        if (!is_array($Accounts->cGrootboekrekening)) // Ledger account
            $Accounts->cGrootboekrekening = array($Accounts->cGrootboekrekening);
        // show all ledger accounts - Rekeningen
        // echo '<table>';  
        return $Accounts->cGrootboekrekening;  // Ledger account      
    }
    public function CloseSession()
    {
        // close session
        $params = array(
            "SessionID" => $this->session_id
        );
        $response = $this->client->__soapCall("CloseSession", array($params));
    }

    // standard error handling
    function checkforerror($rawresponse, $sub)
    {
        // $LastErrorCode = $rawresponse->{$sub}->ErrorMsg->LastErrorCode;
        // $LastErrorDescription = $rawresponse->{$sub}->ErrorMsg->LastErrorDescription;
        // $LastErrorCode = $rawresponse->$sub->ErrorMsg->LastErrorCode;
        $ErrorMsg = $rawresponse->$sub->ErrorMsg;
        // print_r($ErrorMsg);
        // die();
        if (isset($ErrorMsg->LastErrorCode)) {
            $LastErrorCode = $ErrorMsg->LastErrorCode;
            if ($LastErrorCode <> '') {
                $LastErrorDescription = $ErrorMsg->LastErrorDescription;
                echo '<strong>Er is een fout opgetreden:</strong><br>';
                echo $LastErrorCode . ': ' . $LastErrorDescription;
                exit();
            }
        }
    }
}
