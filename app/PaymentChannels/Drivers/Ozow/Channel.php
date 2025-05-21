<?php


namespace App\PaymentChannels\Drivers\Ozow;

use App\Models\Order;
use App\Models\PaymentChannel;
use App\PaymentChannels\BasePaymentChannel;
use Illuminate\Http\Request;
use App\PaymentChannels\IChannel;


class Channel extends BasePaymentChannel implements IChannel
{
    protected array $credentialItems = [
        'site_code',
        'private_key',
        'api_key',
        'test_mode'
    ];

    protected $site_code;
    protected $private_key;
    protected $api_key;
    protected $test_mode;

    public function __construct(PaymentChannel $paymentChannel){

        $this->setCredentialItems($paymentChannel);
    }

    public function paymentRequest(Order $order)
    {
        $data = [
            'countryCode' => 'ZA',
            'currencyCode' => 'ZAR',
            'amount' => $order->total_amount,
            'transactionReference' => 'Order #' . $order->id,
            'bankReference' => 'CampusMarket Order #' . $order->id,
            'cancelUrl' => url("/payments/cancel/Ozow"),
            'errorUrl' => url('payments/errorhandler/Ozow'),
            'isTest' => $this->test_mode,
            'notifyUrl' => url("/payments/verify/Ozow"),
            'siteCode' => $this->site_code,
            'successUrl' => url("/payments/success/Ozow"),
            //'payeeDisplayName' => 'Campus Market'
        ];

        $inputStr = $this->generateCombinedString($data);
        $requestHash = $this->generateRequestHash($inputStr);
        $data['HashCheck'] = $requestHash;

        // Validate JSON
        $jsonData = json_encode($data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'JSON Error: ' . json_last_error_msg();
            return;
        }
        //initialize the cURL
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => 'https://api.ozow.com/postpaymentrequest',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
           // CURLOPT_CAINFO => __DIR__ . '/../../../../cacert.pem',
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_VERBOSE => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'ApiKey:' . $this->api_key,
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($ch);

          $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

          if ($response === false) {
            $error = curl_error($ch);
            echo 'cURL Error: ' . $error;
            } else {
                echo 'HTTP Status Code: ' . $httpCode;
                echo 'Response: ' . $response;
            }
          if (curl_errno($ch)) {
              $error_msg = curl_error($ch);
              // Handle error
              echo 'Error: ' . $error_msg;
          }

        curl_close($ch);
        echo $response;
    }

    public function verify(Request $request)
    {
            $data = [
                'SiteCode' => $request['SiteCode'],
                'TransactionId' => $request['TransactionId'],
                'TransactionReference' => $request['TransactionReference'],
                'Amount' => $request['Amount'],
                'Status' => $request['Status'],
                'Optional1' => $request['Optional1'],
                'Optional2' => $request['Optional2'],
                'Optional3' => $request['Optional3'],
                "Optional4" => $request['Optional4'],
                'Optional5' => $request['Optional5'],
                'CurrencyCode' => $request['CurrencyCode'],
                'IsTest' => $request['IsTest'],
                'StatusMessage' => $request['StatusMessage'],
                'Hash' => $request['Hash'],
                'SubStatus' => $request['SubStatus'],
                'MaskedAccountNumber' => $request['MaskedAccountNumber'],
                'BankName' => $request['BankName'],
                'SmartIndicators' => $request['SmartIndicators'],
            ];

            if($this->isValidResponse($data)){
                 switch($data['Status']){
                    case 'COMPLETE':
                        $order = Order::where('id', $data['TransactionId'])->first();

                        break;
                    case '':

                        break;
                    default:

                        break;
                    }
                }


    }

    public function success(Request $request)
    {

    }
    public function cancel(Request $request)
    {

    }
    public function getCredentialItems(): array
    {
        return ['site_code', 'private_key', 'api_key', 'test_mode'];
    }
    function generateCombinedString($data)
    {
        $combinedString = '';
        foreach($data as $key => $value){
            $combinedString .= $value;
        }
        $combinedString .= $this->private_key;
        return $combinedString;
    }
    function generateRequestHash($inputString){
        $stringToHash = strtolower($inputString);
        $bytes = hash('sha512', $stringToHash, true);
        $hex = bin2hex($bytes);
        return $hex;
    }
    function isValidResponse($response):bool{
        $strVal = $this->generateCombinedString($response);
        $responseHash = $this->generateRequestHash($strVal);
        return $responseHash == $response["Hash"];
    }

}
