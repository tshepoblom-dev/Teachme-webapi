<?php

namespace App\PaymentChannels\Drivers\PayFast;
use App\Models\Order;
use App\Models\PaymentChannel;
use App\PaymentChannels\BasePaymentChannel;
use Illuminate\Http\Request;
use App\PaymentChannels\IChannel;
use Exception;

class Channel extends BasePaymentChannel implements IChannel
{
    protected array $credentialItems = [
        'merchant_id',
        'merchant_key',
        'passphrase'
    ];

    protected $merchant_id;
    protected $merchant_key;
    protected $passphrase;
    protected $test_mode;
    protected $order_session_key;

    public function __construct(PaymentChannel $paymentChannel){

        $this->setCredentialItems($paymentChannel);
        $this->order_session_key = 'payfast.payments.order_id';
    }
    public function convertToHttpsUrls($data):array {
        foreach ($data as $key => $value) {
            // Check if the key contains 'url'
            if (strpos($key, 'url') !== false) {
                // Replace 'http' with 'https' in the value
                $data[$key] = str_replace('http:', 'https:', $value);
            }
        }
        return $data;
    }
    public function paymentRequest(Order $order)
    {
        try{

        session()->put($this->order_session_key, $order->id);
        $amount = $this->makeAmountByCurrency($order->total_amount, $order->currency);
        $passphrase = $this->test_mode ? 'Teachmeapp2024' : $this->passphrase;
        $data = [
            'merchant_id' => $this->test_mode ? '10011546' : $this->merchant_id,
            'merchant_key' => $this->test_mode ? 'ru0uwhy438i6k' : $this->merchant_key,
            'return_url' => url("/payments/verify/PayFast"),
            'cancel_url' => url("/payments/verify/PayFast"),
            'notify_url' => url("/payments/verify/PayFast"),
            'm_payment_id' => $order->id,
            'amount' => $amount,
            'item_name' => 'Meeting reservation'
        ];

        $updatedData = $this->convertToHttpsUrls($data);
        $signature = $this->generateSignature($updatedData, $passphrase);
        $updatedData['signature'] = $signature;

        // If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
        $pfHost = $this->test_mode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
        $url = 'https://' . $pfHost . '/eng/process';

        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($updatedData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            // Handle error
            echo 'Error: ' . $error_msg;
        }

        // Close cURL session
        curl_close($ch);

        // Process the response
        echo $response;
        }
        catch(Exception $ex){
            dd($ex);
        }
    }



    public function verify(Request $request)
    {
        try
        {
            $ITN_Payload = $request->all();


            if(isset($ITN_Payload['payment_status'])){
                switch($ITN_Payload['payment_status']){
                    case "COMPLETE":
                        $amount_gross = $ITN_Payload['amount_gross'];
                        $amount_fee = $ITN_Payload['amount_fee'];
                        $amount_net = $ITN_Payload['amount_net'];
                        $pf_payment_id = $ITN_Payload['pf_payment_id'];
                        $signature = $ITN_Payload['signature'];
                        $merchantid = $ITN_Payload['merchant_id'];
                        $m_payment_id =  $ITN_Payload['m_payment_id'];
                        $user = auth()->user();
                        $order = Order::where('id', $m_payment_id)->first();
                        $order->update(['product_delivery_fee' =>abs($amount_fee),
                                        'amount' => $amount_net,
                                        'reference_id' => $pf_payment_id,
                                        'status' => 'paying']);
                        return $order;
                        break;
                    case "CANCELLED":
                        default:
                        break;
                }
            }
            else{
                $order_id = session()->get($this->order_session_key, null);
                session()->forget($this->order_session_key);
                $order = Order::where('id', $order_id)->first();
                return $order;
            }
        }
        catch(Exception $ex){
            dd($ex);
        }
    }

    public function getCredentialItems(): array
    {
        return ['merchant_id', 'merchant_key', 'passphrase', 'test_mode'];
    }

    function generateSignature($data, $passPhrase = null) {
        $signatureString = '';
        foreach ($data as $key => $value) {
            if ($key !== 'signature') {
                $signatureString .= $key . '=' . urlencode($value) . '&';
            }
        }
        $signatureString = rtrim($signatureString, '&');
        return md5($signatureString . '&passphrase=' . $passPhrase);
    }
}
