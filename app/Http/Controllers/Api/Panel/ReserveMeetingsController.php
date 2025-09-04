<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Api\Controller;
use App\Models\Api\Meeting;
use App\Models\Api\ReserveMeeting;
use App\Models\Session;
use \Illuminate\Http\Request;
use App\Models\Api\Cart;
use App\Models\Translation\SessionTranslation;


class ReserveMeetingsController extends Controller
{
    public function index(Request $request)
    {

        $data = [
            'reservations' => [
                'count'=>count($this->getReservation()) ,
                'meetings' => $this->getReservation(),
            ],
            'requests' =>[
                'count'=>count( $this->getRequests()) ,
                'meetings'=> $this->getRequests()
            ],
        ];
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $data);

    }

    public function show(Request $request, $id)
    {
        $user = apiAuth();
        $reserveMeetingsQuery = ReserveMeeting::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)->orWhere(function ($q) use ($user) {

                    $q->whereHas('meeting', function ($qq) use ($user) {
                        $meetingIds = Meeting::where('creator_id', $user->id)->pluck('id');
                        $qq->whereIn('meeting_id', $meetingIds);
                    });
                });
            })
            ->first();
        if ($reserveMeetingsQuery){
            $reserveMeetingsQuery->isAgora = false;
            $reserveMeetingsQuery->agoraLink = null;
            $session = Session::where("reserve_meeting_id","=",$reserveMeetingsQuery->id)->first();
            if ($session){
                $reserveMeetingsQuery->isAgora = true;
                $reserveMeetingsQuery->agoraLink = route('agora.api.join',$session->id);
            }

        }
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), [
            'meeting' => $reserveMeetingsQuery
        ]);


    }

    public function reservation(Request $request)
    {


        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'),
            $this->getReservation()
        );

    }

    public function requests(Request $request)
    {
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'),
            $this->getRequests()
        );
    }
/*
    public function getReservation()
    {

        $user = apiAuth();
        $reservedMeetings = ReserveMeeting::where('user_id', $user->id)
            ->whereHas('sale')
            ->whereNotNull('reserved_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($reserveMeeting) {
                return $reserveMeeting->details;
            });

        return $reservedMeetings;
    }*/
    public function getReservation()
    {
        $user = apiAuth();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = ReserveMeeting::query()
            ->whereHas('sale') // ensure a related sale exists
            ->whereNotNull('reserved_at') // ensure it's reserved
            ->orderBy('created_at', 'desc');

        if ($user->isTeacher()) {
            $meetingIds = Meeting::where('creator_id', $user->id)->pluck('id');
            $query->whereIn('meeting_id', $meetingIds);
        } else {
            $query->where('user_id', $user->id);
        }

        $reservedMeetings = $query->get()
            ->map(fn($reserveMeeting) => $reserveMeeting->details);

        return $reservedMeetings;
    }

/*
    public function getRequests()
    {
        $user = apiAuth();
        $meetingIds = Meeting::where('creator_id', $user->id)->pluck('id');
        $reservedMeetings = ReserveMeeting::whereIn('meeting_id', $meetingIds)->whereHas('sale')
            ->orderBy('created_at', 'desc')
            ->get()->map(function ($reserveMeeting) {
                return $reserveMeeting->details;
            });

        return $reservedMeetings;
    }
*/
   public function getRequests()
    {
        $user = apiAuth();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = ReserveMeeting::query();

        if ($user->isTeacher()) {
            $meetingIds = Meeting::where('creator_id', $user->id)->pluck('id');
            $query->whereIn('meeting_id', $meetingIds);
        } else {
            $query->where('user_id', $user->id);
        }

        $reservedMeetings = $query->orderBy('created_at', 'desc')->get()
            ->map(fn($reserveMeeting) => $reserveMeeting->details);

        return $reservedMeetings;
    }


    public function finish($id)
    {
        $user = apiAuth();

        $meetingIds = Meeting::where('creator_id', $user->id)->pluck('id');

        $ReserveMeeting = ReserveMeeting::where('id', $id)
            ->where(function ($query) use ($user, $meetingIds) {
                $query->where('user_id', $user->id)
                    ->orWhereIn('meeting_id', $meetingIds);
            })
            ->first();

        if (!empty($ReserveMeeting)) {
            $ReserveMeeting->update([
                'status' => ReserveMeeting::$finished
            ]);

            //check if it exist in the cart
             $carts = Cart::where('reserve_meeting_id', $ReserveMeeting->id)->get();
             if(!empty($carts)){
                Cart::whereIn('id', $carts->pluck('id'))->delete();
             }

            $notifyOptions = [
                '[student.name]' => $ReserveMeeting->user->full_name,
                '[instructor.name]' => $ReserveMeeting->meeting->creator->full_name,
                '[time.date]' => $ReserveMeeting->day,
            ];
            sendNotification('meeting_finished', $notifyOptions, $ReserveMeeting->user_id);
            sendNotification('meeting_finished', $notifyOptions, $ReserveMeeting->meeting->creator_id);

            return apiResponse2(1, 'finished',
                trans('api.meeting.finished'));

        }
        abort(404);

    }
//not used because we put the logiv  directly into PaymentController and PaymentsController: TBlom 17July2025
     public function createLiveSession(Request $request, $id)
    {
        try
        {

            $user = apiAuth();

        // $meetingIds = Meeting::where('creator_id', $user->id)->pluck('id');

            $ReserveMeeting = ReserveMeeting::where('id', $id)
            ->where('user_id', $user->id) // regular user must be the one who made the reservation
            ->first();

        /* $ReserveMeeting = ReserveMeeting::where('id', $id)
                ->whereIn('meeting_id', $meetingIds)
                ->first();
    */

            if (!empty($ReserveMeeting)) {
                $agoraSettings = [
                    'chat' => true,
                    'record' => true,
                    'users_join' => true
                ];

                $session = Session::query()->updateOrCreate([
                    //'creator_id' => $user->id,
                    'creator_id' => $ReserveMeeting->meeting->creator_id,
                    'reserve_meeting_id' => $ReserveMeeting->id,
                ], [
                    //'date' => time(), // can start now
                    'date' => $ReserveMeeting->start_at,
                    'duration' => (($ReserveMeeting->end_at - $ReserveMeeting->start_at) / 60),
                    'link' => $this->getJoinLink(),
                    'session_api' => 'agora',
                    'agora_settings' => json_encode($agoraSettings),
                    'check_previous_parts' => false,
                    'status' => Session::$Active,
                    'created_at' => time()
                ]);

                if (!empty($session)) {
                    SessionTranslation::updateOrCreate([
                        'session_id' => $session->id,
                        'locale' => mb_strtolower(app()->getLocale()),
                    ], [
                        'title' => trans('update.new_in-app_call_session'),
                        'description' => trans('update.new_in-app_call_session'),
                    ]);
                    //meeting status will be set to open when a user pays

                    $ReserveMeeting->update([
                        'status' => ReserveMeeting::$open,
                        'link' => $session->getJoinLink(),
                    ]);

                    $notifyOptions = [
                        '[link]' => $session->getJoinLink(),
                        '[instructor.name]' => $user->full_name,
                        '[time.date]' => dateTimeFormat($session->date, 'j M Y H:i'),
                    ];
                    sendNotification('new_appointment_session', $notifyOptions, $ReserveMeeting->user_id);

                    sendNotification('new_appointment_session', $notifyOptions, $ReserveMeeting->meeting->creator_id);

                    return response()->json([
                        'code' => 200
                    ]);
                }
            }
        }
        catch(\Exception $ex){

        }

        return response()->json([], 422);
    }

}
