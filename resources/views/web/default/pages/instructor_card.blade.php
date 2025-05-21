@php
    $canReserve = false;
    if (!empty($instructor->meeting) && !$instructor->meeting->disabled && !empty($instructor->meeting->meetingTimes) && $instructor->meeting->meeting_times_count > 0) {
        $canReserve = true;
    }
@endphp

<div class="rounded-lg shadow-sm mt-25 p-20 course-teacher-card instructors-list d-flex align-items-center position-relative" style="display: flex; flex-direction: row; align-items: center; background: #fff; border-radius: 10px;">

    <div class="position-relative" style="flex-shrink: 0; width: 100px; height: 100px; border-radius: 10px; overflow: hidden; margin-right: 15px;">
        <img src="{{ $instructor->getAvatar(100) }}" class="img-cover w-100 h-100" alt="{{ $instructor->full_name }}">

        @if($instructor->offline)
            <span class="user-circle-badge unavailable d-flex align-items-center justify-content-center">
                <i data-feather="slash" width="20" height="20" class="text-white"></i>
            </span>
        @elseif($instructor->verified)
            <span class="user-circle-badge has-verified d-flex align-items-center justify-content-center">
                <i data-feather="check" width="20" height="20" class="text-white"></i>
            </span>
        @endif
    </div>

    <div class="d-flex flex-column flex-grow-1">
        <a href="{{ $instructor->getProfileUrl() }}{{ ($canReserve) ? '?tab=appointments' : '' }}" class="text-dark-blue font-16 font-weight-bold">
            {{ $instructor->full_name }}
        </a>

        <div class="mt-5 font-14 text-gray">
            @if(!empty($instructor->bio))
                {{ $instructor->bio }}
            @elseif(!empty($instructor->about))
                {{ $instructor->about}}
            @endif
        </div>
        <div class="mt-5 font-12 text-gray">
            {{ !empty($instructor->institution_name) ? $instructor->institution_name : "" }}
        </div>
        <div class="mt-5 font-12 text-gray">
            {{ !empty($instructor->study_course) ? $instructor->study_course : "" }}
        </div>
        <div class="stars-card d-flex align-items-center mt-10">
            @include('web.default.includes.webinar.rate',['rate' => $instructor->rates()])
        </div>

        <div class="d-flex align-items-center mt-10">
            @foreach($instructor->getBadges() as $badge)
                <div class="mr-10" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{!! (!empty($badge->badge_id) ? nl2br($badge->badge->description) : nl2br($badge->description)) !!}">
                    <img src="{{ !empty($badge->badge_id) ? $badge->badge->image : $badge->image }}" width="24" height="24" alt="{{ !empty($badge->badge_id) ? $badge->badge->title : $badge->title }}">
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            @if(!empty($instructor->meeting) && !$instructor->meeting->disabled && !empty($instructor->meeting->amount))
                @if(!empty($instructor->meeting->discount))
                    <span class="font-20 text-primary font-weight-bold">{{ handlePrice($instructor->meeting->amount - (($instructor->meeting->amount * $instructor->meeting->discount) / 100)) }}</span>
                    <span class="font-14 text-gray text-decoration-line-through ml-10">{{ handlePrice($instructor->meeting->amount) }}</span>
                @else
                    <span class="font-20 text-primary font-weight-500">{{ handlePrice($instructor->meeting->amount) }}</span>
                @endif
            @endif
        </div>

        <div class="mt-15">
            <a href="{{ $instructor->getProfileUrl() }}{{ ($canReserve) ? '?tab=appointments' : '' }}" class="btn btn-primary btn-sm">
                @if($canReserve)
                    {{ trans('public.reserve_a_meeting') }}
                @else
                    {{ trans('public.view_profile') }}
                @endif
            </a>
        </div>
    </div>
</div>
