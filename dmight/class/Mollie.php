<?

use Mollie\Api\MollieApiClient;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Types\PaymentMethod;

class Mollie
{
    private $mollie;
    private $apiKey;
    public  $CheckoutUrl;

    public  $redirectUrl;
    public  $webhookUrl;

    function __construct(
        $redirectUrl, 
        $webhookUrl, 
        $api_key = "test_hBRgCxDWTgBnVSnwpgvcEGwvg5JW75" )
    {
        // "MOLLIE_KEY" => 'test_hBRgCxDWTgBnVSnwpgvcEGwvg5JW75'
        try {
            $this->apiKey = $api_key; //APP::Constant('MOLLIE_KEY'); 
            $this->redirectUrl  = $redirectUrl; 
            $this->webhookUrl   = $webhookUrl; 

            require_once ROOT . "vendor/autoload.php";

            // See: https://www.mollie.com/dashboard/settings/profiles
            $this->mollie = new MollieApiClient();
            $this->mollie->setApiKey($this->apiKey);

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get()
    {
        return $this->mollie;
    }
    function methodsList()
    {
        try {
            //   Get all the activated methods for this API key.
            $methods = $this->mollie->methods->all();
            foreach ($methods as $method) {
                echo '<div style="line-height:40px; vertical-align:top">';
                echo '<img src="' . htmlspecialchars($method->image->size1x) . '" srcset="' . htmlspecialchars($method->image->size2x) . ' 2x"> ';
                echo htmlspecialchars($method->description) . ' (' . htmlspecialchars($method->id) . ')';
                echo '</div>';
            }
        } catch (ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
    }

    function getMethods()
    {
        try {
            //  * Get all the activated methods for this API key.
            $methods = $this->mollie->methods->all();
            return $methods;
        } catch (ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
    }

    //
    function payWithMethod(
        $document_id,
        $amount,
        $method = PaymentMethod::IDEAL,
        $issuer = null
    ) {

        try {

            // $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
            // $hostname = $_SERVER['HTTP_HOST'];
            // $path = dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);

            //  * Payment parameters:
            //  *   amount        Amount in EUROs. This example creates a € 27.50 payment.
            //  *   method        Payment method "ideal".
            //  *   description   Description of the payment.
            //  *   redirectUrl   Redirect location. The customer will be redirected there after the payment.
            //  *   webhookUrl    Webhook location, used to report when the payment changes state.
            //  *   metadata      Custom metadata that is stored with the payment.
            //  *   issuer        The customer's bank. If empty the customer can select it later.

            // $result_url = get_url("pay-result-page", ["hash" => $invoice_hash], true);
            // $webhook_url = get_url("pay-webhook-page", [], true);
            // $result_url = h_invoices::GetRawResultPage($invoice_hash);
            // $webhook_url =  h_invoices::GetRawWebhook();

// var_dump($this->redirectUrl, $this->webhookUrl, $method);
// die;

            $payment = $this->mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $amount //"27.50" - example
                ],
                "method" => $method, //PaymentMethod::IDEAL,
                "description" => "Order #{$document_id}",
                "redirectUrl" => $this->redirectUrl,
                "webhookUrl" => $this->webhookUrl,
                "metadata" => [
                    "invoice_id" => $document_id,
                ],
                "issuer" => $issuer
            ]);

            $this->CheckoutUrl = $payment->getCheckoutUrl();
            
// dymp($payment, $this->CheckoutUrl);

        } catch (ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
            $this->CheckoutUrl = '';
        }
    }

    // debug function
    function databaseWrite($orderId, $status)
    {
        $orderId = intval($orderId);
        $database = dirname(__FILE__) . "/orders/order-{$orderId}.txt";

        file_put_contents($database, $status);
    }

    // debug function
    function databaseRead($orderId)
    {
        $orderId = intval($orderId);
        $database = dirname(__FILE__) . "/orders/order-{$orderId}.txt";

        $status = @file_get_contents($database);

        return $status ? $status : "unknown order";
    }
}
