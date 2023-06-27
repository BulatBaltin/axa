<?
// web-hook
// http://hair/students/pay-webhook/!debug_id
// http://hairkapper.ibl82.nl/students/pay-webhook/1

use Mollie\Api\Exceptions\ApiException;
// use Mollie\Api\Types\PaymentStatus;

$errors = '';
$result = '';
try {
    $thisDateTime = date('Y-m-d H:i:s');
    dlLog::Write('START ==== Web-hook date = ' . $thisDateTime);
    $debug_id = REQUEST::getParam('debug_id',false,false);
    if($debug_id) {
        $invoice_id = $debug_id;
        $isPaid     = true;
        $isFailed   = false;
        $paidAt     = $thisDateTime;
        $status     = 'paid';
    } else { // production
        $mollie = new Mollie;
        $payment = $mollie->get()->payments->get($_POST["id"]);
        // $payment_info = json_encode($payment);
        $invoice_id = $payment->metadata->invoice_id;
        $isPaid     = $payment->isPaid();
        $isFailed   = $payment->isFailed();
        $paidAt     = $payment->paidAt;
        $status     = $payment->status;
    }
    $paidStatus = $status .'#'. $paidAt;
    dlLog::Write('Order ID = ' . $invoice_id );
    $invoice_gateway = dlModel::Create('h_invoices');
    $invoice = $invoice_gateway->GetRec($invoice_id);

    // $test = true; 
    // if ($isPaid or $test) {
    if ($isPaid) {
        if (!$invoice) {
            dlLog::Write('FINISH: Invoice ID = ' . $invoice_id . ' is not found');
            dlLog::Write('=========');
            exit();
        }

        h_invoices::SetInvoicePaid($invoice_id, $paidStatus, $paidAt);

        $mail = h_invoices::SendStudentInvoicePaid($invoice_id);
        if (!$mail) {
            $errors .= PHP_EOL . "Email about invoice {$invoice_id} being paid was not sent to Student";
            $result = "error";
        }
        $mail = h_invoices::SendAdminInvoicePaid($invoice_id);
        if (!$mail) {
            $errors .= PHP_EOL . "Email about invoice {$invoice_id} being paid was not sent to Admin";
            $result = "error";
        }
        dlLog::Write('PAID Invoice ID = ' . $invoice_id);

    } else {
        $paidStatus = $status . '#'. $thisDateTime;
        h_invoices::SetInvoicePaymentStatus( $invoice_id, $paidStatus);

        if ($isFailed) {
            /*
             * The payment has failed.
             */
            $mail = h_invoices::SendStudentAboutFailedPayment($invoice_id);
            if (!$mail) {
                $errors = "Email about failed payment was not sent to student";
                $result = "error";
            }
        } 
        // elseif(
        //     $payment->isOpen() 
        //     OR $payment->isPending()
        //     OR $payment->isExpired()
        //     OR $payment->isCanceled()
        //     ) 
        // {
        // }
    } 
    dlLog::Write('FINISH: Invoice ID = ' . $invoice_id. ' Status ' . $paidStatus);

} catch (ApiException $e) {
    dlLog::Write('FINISH: Web-hook-EXCEPTION ' . htmlspecialchars($e->getMessage()));
} catch (Exception $e) {
    dlLog::Write('FINISH: Exception: ' . htmlspecialchars($e->getMessage()));
}

if($errors) {
    dlLog::Write("Mail errors: " . $errors);
} 
dlLog::Write('end ==========');
exit();
