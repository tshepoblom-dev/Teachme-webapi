<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentChannel;
use App\Models\ReserveMeeting;
use App\Models\Sale;
use App\Models\Session;
use App\Models\Translation\SessionTranslation;
use App\Models\TicketUser;
use App\PaymentChannels\ChannelManager;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;


class PaymentsController extends Controller
{
    protected $order_session_key;

    public function __construct()
    {
        $this->order_session_key = 'payment.order_id';
    }

    public function paymentByCredit(Request $request)
    {
        try
        {            
            validateParam($request->all(), [
                'order_id' => ['required',
                    Rule::exists('orders', 'id')->where('status', Order::$pending),

                ],
            ]);

            $user = apiAuth();
            $orderId = $request->input('order_id');

            $order = Order::where('id', $orderId)
                ->where('user_id', $user->id)
                ->first();


            if ($order->type === Order::$meeting) {
                $orderItem = OrderItem::where('order_id', $order->id)->first();
                $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
                $reserveMeeting->update(['locked_at' => time()]);
            }

            if ($user->getAccountingCharge() < $order->amount) {
                $order->update(['status' => Order::$fail]);

                return apiResponse2(0, 'not_enough_credit', trans('api.payment.not_enough_credit'));

            }

            $order->update([
                'payment_method' => Order::$credit
            ]);

            $this->setPaymentAccounting($order, 'credit');

            $order->update([
                'status' => Order::$paid
            ]);

            if($reserveMeeting){
                $session = createReserveMeetingLiveSession($reserveMeeting->id);
            }
            return apiResponse2(1, 'paid', trans('api.payment.paid'));
        }
        catch(\Exception $ex){

            return apiResponse2(0, 'payment_error', $ex->getMessage());
        }
    }


    public function paymentRequest(Request $request)
    {
        $user = apiAuth();
        if($user == null){
            $userid = $request->input('userid');
            $user = User::find($userid);
            Auth::login($user);
        }
        validateParam($request->all(), [
            'gateway_id' => ['required',
                Rule::exists('payment_channels', 'id')
            ],
            'order_id' => ['required',
                Rule::exists('orders', 'id')->where('status', Order::$pending)
                    ->where('user_id', $user->id),

            ],


        ]);


        $gateway = $request->input('gateway_id');
        $orderId = $request->input('order_id');

        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();


        if ($order->type === Order::$meeting) {
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
            $reserveMeeting->update(['locked_at' => time()]);
        }

        $paymentChannel = PaymentChannel::where('id', $gateway)
            ->where('status', 'active')
            ->first();

        if (!$paymentChannel) {
            return apiResponse2(0, 'disabled_gateway', trans('api.payment.disabled_gateway'));
        }

        $order->payment_method = Order::$paymentChannel;
        $order->save();

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $redirect_url = $channelManager->paymentRequest($order);


            if (in_array($paymentChannel->class_name, ['Paytm', 'Payu', 'Zarinpal', 'Stripe', 'Paysera', 'Cashu', 'Iyzipay', 'MercadoPago'])) {

                return $redirect_url;
            }

            return $redirect_url;
            //      dd($redirect_url) ;
            //return Redirect::away($redirect_url);

        } catch (\Exception $exception) {

            if (!$paymentChannel) {
                return apiResponse2(0, 'gateway_error', trans('api.payment.gateway_error'));
            }

        }
    }


    public function paymentVerify(Request $request, $gateway)
    {
        
        Log::info('Api\Panel\PaymentsController@paymentVerify() reached',[]);
        $paymentChannel = PaymentChannel::where('class_name', $gateway)
            ->where('status', 'active')
            ->first();

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $order = $channelManager->verify($request);

            if (!empty($order)) {
                session()->put($this->order_session_key, $order->id);

                $orderItem = OrderItem::where('order_id', $order->id)->first();

                $reserveMeeting = null;
                if ($orderItem && $orderItem->reserve_meeting_id) {
                    $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
                }

                if ($order->status == Order::$paying) {
                    $this->setPaymentAccounting($order);

                    $order->update(['status' => Order::$paid]);
                      // Create Live Session here: TBLOM 16JULY2025
                    if ($reserveMeeting) {
                        $session = createReserveMeetingLiveSession(reserveMeetingId: $orderItem->reserve_meeting_id);
                    }

                } else {
                    if ($order->type === Order::$meeting) {
                        $reserveMeeting->update(['locked_at' => null]);
                    }
                    Log::log('Payment pending for order ID: '.$order->id, [
                        'order_id' => $order->id,
                        'user_id' => $order->user_id
                    ]);
                    return response()->json([
                        'status' => 'pending',
                        'message' => 'Payment still pending.',
                        'order' => $order,
                    ], 202);
                }

                //session()->put($this->order_session_key, $order->id);

               // return redirect('/payments/status');

                     return response()->json([
                        'status' => 'success',
                        'message' => 'Payment verified successfully.',
                        'order' => $order,
                        //'session' => $session,
                    ], 200);

            } else {
               /* $toastData = [
                    'title' => trans('cart.fail_purchase'),
                    'msg' => trans('cart.gateway_error'),
                    'status' => 'error'
                ];*/
                Log::error('Payment verification failed: Order not found', [
                    'gateway' => $gateway,
                    'request_data' => $request->all()
                ]);
                //return redirect('cart')->with($toastData);
                return response()->json([
                    'status' => 'error',
                    'message' => trans('cart.gateway_error'),
                ], 400);    
            }

        } catch (\Exception $exception) {
         /*   $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return redirect('cart')->with(['toast' => $toastData]);
            */
                Log::error('PayFast verification failed: '.$exception->getMessage(), [
                'trace' => $exception->getTraceAsString()
            ]);
            //return redirect('cart')->with(['toast' => $toastData]);
            return response()->json([
                'status' => 'error',
                'message' => trans('cart.gateway_error'),
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function setPaymentAccounting($order, $type = null)
    {
        if ($order->is_charge_account) {
            Accounting::charge($order);
        } else {
            foreach ($order->orderItems as $orderItem) {
                $sale = Sale::createSales($orderItem, $order->payment_method);

                if (!empty($orderItem->reserve_meeting_id)) {
                    $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
                    $reserveMeeting->update([
                        'sale_id' => $sale->id,
                        'reserved_at' => time()
                    ]);
                }

                if (!empty($orderItem->subscribe_id)) {
                    Accounting::createAccountingForSubscribe($orderItem, $type);
                } elseif (!empty($orderItem->promotion_id)) {
                    Accounting::createAccountingForPromotion($orderItem, $type);
                } else {
                    // webinar and meeting

                    Accounting::createAccounting($orderItem, $type);
                    TicketUser::useTicket($orderItem);
                }
            }
        }

        Cart::emptyCart($order->user_id);
    }

    public function payStatus(Request $request)
    {
        $orderId = $request->get('order_id', null);

        if (!empty(session()->get($this->order_session_key, null))) {
            $orderId = session()->get($this->order_session_key, null);
            session()->forget($this->order_session_key);
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if (!empty($order)) {
            $data = [
                'pageTitle' => trans('public.cart_page_title'),
                'order' => $order,
            ];

            //return view('web.default.cart.status_pay', $data);
            return response()->json([
                'status' => 'success',
                'message' => 'Order status retrieved successfully',
                'data' => json_encode($data),
            ], 200);
        }

        abort(404);
    }

    public function webChargeGenerator(Request $request)
    {
        return apiResponse2(1, 'generated', trans('api.link.generated'),
            [
                'link' => URL::signedRoute('my_api.web.charge', [apiAuth()->id])
            ]
        );

    }

    public function webChargeRender(User $user)
    {
        Auth::login($user);
        return redirect('/panel/financial/account');

    }


    public function charge(Request $request)
    {
        validateParam($request->all(), [
            'amount' => 'required|numeric',
            'gateway_id' => ['required',
                Rule::exists('payment_channels', 'id')->where('status', 'active')
            ]
            ,
        ]);


        $gateway_id = $request->input('gateway_id');
        $amount = $request->input('amount');

        $userAuth = apiAuth();

        $paymentChannel = PaymentChannel::find($gateway_id);

        $order = Order::create([
            'user_id' => $userAuth->id,
            'status' => Order::$pending,
            'payment_method' => Order::$paymentChannel,
            'is_charge_account' => true,
            'total_amount' => $amount,
            'amount' => $amount,
            'created_at' => time(),
            'type' => Order::$charge,
        ]);


        OrderItem::updateOrCreate([
            'user_id' => $userAuth->id,
            'order_id' => $order->id,
        ], [
            'amount' => $amount,
            'total_amount' => $amount,
            'tax' => 0,
            'tax_price' => 0,
            'commission' => 0,
            'commission_price' => 0,
            'created_at' => time(),
        ]);


        if ($paymentChannel->class_name == 'Razorpay') {
            return $this->echoRozerpayForm($order);
        } else {
            $paymentController = new PaymentsController();

            $paymentRequest = new Request();
            $paymentRequest->merge([
                'gateway_id' => $paymentChannel->id,
                'order_id' => $order->id
            ]);

            return $paymentController->paymentRequest($paymentRequest);
        }
    }

    // In PaymentsController.php
    public function api_charge(Request $request)
    {
        try{
            
        validateParam($request->all(), [
            'amount' => 'required|numeric|min:1',
            'gateway_id' => ['required',
                Rule::exists('payment_channels', 'id')->where('status', 'active')
            ]
            ,
        ]);


        $gateway_id = $request->input('gateway_id');
        $amount = $request->input('amount');
        $userAuth = apiAuth();

        $paymentChannel = PaymentChannel::find($gateway_id);

        if (!$paymentChannel) {
            return apiResponse2(0, 'invalid_gateway', trans('api.payment.invalid_gateway'));
        }
        $order = Order::create([
            'user_id' => $userAuth->id,
            'status' => Order::$pending,
            'payment_method' => Order::$paymentChannel,
            'is_charge_account' => true,
            'total_amount' => $amount,
            'amount' => $amount,
            'created_at' => time(),
            'type' => Order::$charge,
        ]);


        OrderItem::updateOrCreate([
            'user_id' => $userAuth->id,
            'order_id' => $order->id,
        ], [
            'amount' => $amount,
            'total_amount' => $amount,
            'tax' => 0,
            'tax_price' => 0,
            'commission' => 0,
            'commission_price' => 0,
            'created_at' => time(),
        ]);

        // Set payment method and save order
        $order->payment_method = Order::$paymentChannel;
        $order->save();

        
        //    $channelManager = ChannelManager::makeChannel($paymentChannel);
        //    $redirect_url = $channelManager->paymentRequest($order);

        //    return Redirect::away($redirect_url);
            // Return the redirect URL for webview
              return apiResponse2(1, 'payment_redirect', trans('api.payment.redirect_url'), [
                //'redirect_url' => $redirect_url,
                'gateway' => $paymentChannel->class_name,
                'order_id' => $order->id,
                'gateway_id' => $gateway_id,
                'user_id' => $userAuth->id,
            ]);

        } catch (\Exception $exception) {
            return apiResponse2(0, 'gateway_error', trans('api.payment.gateway_error'));
        }
    }

    public function getPaymentChannels(Request $request){
        try
        {
            $paymentChannels = PaymentChannel::where('status', 'active')->get();
            $data = [
                'paymentChannels' => $paymentChannels
            ];

            return apiResponse2(1, 'charge', 'payment channels', $data);

        }
        catch(\Exception $ex){
            return apiResponse2(0, 'charge_failed', 'Failed to get payment channels');
        }
    }
    // Add a new method to handle charge verification
    public function chargeVerify(Request $request, $gateway)
    {
        $paymentChannel = PaymentChannel::where('class_name', $gateway)
            ->where('status', 'active')
            ->first();

        if (!$paymentChannel) {
            return apiResponse2(0, 'invalid_gateway', trans('api.payment.invalid_gateway'));
        }

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $order = $channelManager->verify($request);

            if (!empty($order) && $order->type === Order::$charge) {
                if ($order->status == Order::$paying) {
                    $this->setPaymentAccounting($order);
                    $order->update(['status' => Order::$paid]);

                    return apiResponse2(1, 'charge_success', trans('api.payment.charge_success'), [
                        'order_id' => $order->id,
                        'amount' => $order->amount
                    ]);
                }
            }

            return apiResponse2(0, 'charge_failed', trans('api.payment.charge_failed'));

        } catch (\Exception $exception) {
            return apiResponse2(0, 'verification_error', trans('api.payment.verification_error'));
        }
    }
    private function prepareRazorpayMobilePayment($order)
    {
        $razorpayKey = env('RAZORPAY_API_KEY');
        $amountInPaise = (int)($order->total_amount * 100);

        return apiResponse2(1, 'razorpay_data', trans('api.payment.razorpay_data'), [
            'key' => $razorpayKey,
            'amount' => $amountInPaise,
            'currency' => currency(),
            'order_id' => $order->id,
            'name' => $order->user->full_name,
            'email' => $order->user->email,
            'prefill' => [
                'contact' => $order->user->mobile ?? '',
                'email' => $order->user->email
            ],
            'notes' => [
                'user_id' => $order->user->id,
                'order_id' => $order->id
            ]
        ]);
    }
    private function echoRozerpayForm($order)
    {
        $generalSettings = getGeneralSettings();

        echo '<form action="/payments/verify/Razorpay" method="get">
            <input type="hidden" name="order_id" value="' . $order->id . '">

            <script src="/assets/default/js/app.js"></script>
            <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="' . env('RAZORPAY_API_KEY') . '"
                    data-amount="' . (int)($order->total_amount * 100) . '"
                    data-buttontext="product_price"
                    data-description="Rozerpay"
                    data-currency="' . currency() . '"
                    data-image="' . $generalSettings['logo'] . '"
                    data-prefill.name="' . $order->user->full_name . '"
                    data-prefill.email="' . $order->user->email . '"
                    data-theme.color="#43d477">
            </script>

            <style>
                .razorpay-payment-button {
                    opacity: 0;
                    visibility: hidden;
                }
            </style>

            <script>
                $(document).ready(function() {
                    $(".razorpay-payment-button").trigger("click");
                })
            </script>
        </form>';
        return '';
    }

}
