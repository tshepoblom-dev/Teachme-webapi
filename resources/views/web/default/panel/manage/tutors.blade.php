@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')

    <form id="filtersForm" action="/{{ $page }}" method="get">

        <div id="topFilters" class="mt-5 shadow-lg border border-gray300 rounded-sm p-10 p-md-20">
            <div class="row align-items-center">
              {{--
                <div class="col-lg-9 d-block d-md-flex align-items-center justify-content-start my-25 my-lg-0">
                    <div class="d-flex align-items-center justify-content-between justify-content-md-center">
                        <label class="mb-0 mr-10 cursor-pointer" for="available_for_meetings">{{ trans('public.available_for_meetings') }}</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="available_for_meetings" class="custom-control-input" id="available_for_meetings" @if(request()->get('available_for_meetings',null) == 'on') checked="checked" @endif>
                            <label class="custom-control-label" for="available_for_meetings"></label>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between justify-content-md-center mx-0 mx-md-20 my-20 my-md-0">
                        <label class="mb-0 mr-10 cursor-pointer" for="free_meetings">{{ trans('public.free_meetings') }}</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="free_meetings" class="custom-control-input" id="free_meetings" @if(request()->get('free_meetings',null) == 'on') checked="checked" @endif>
                            <label class="custom-control-label" for="free_meetings"></label>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between justify-content-md-center">
                        <label class="mb-0 mr-10 cursor-pointer" for="discount">{{ trans('public.discount') }}</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="discount" class="custom-control-input" id="discount" @if(request()->get('discount',null) == 'on') checked="checked" @endif>
                            <label class="custom-control-label" for="discount"></label>
                        </div>
                    </div>
                </div>
                --}}

                <div class="col-lg-3 d-flex align-items-center">
                    <select name="sort" class="form-control">
                        <option disabled selected>{{ trans('public.sort_by') }}</option>
                        <option value="">{{ trans('public.all') }}</option>
                        <option value="top_rate" @if(request()->get('sort',null) == 'top_rate') selected="selected" @endif>{{ trans('site.top_rate') }}</option>
                        <option value="top_sale" @if(request()->get('sort',null) == 'top_sale') selected="selected" @endif>{{ trans('site.top_sellers') }}</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="mt-30 px-20 py-15 rounded-sm shadow-lg border border-gray300">
            <h3 class="category-filter-title font-20 font-weight-bold">Academic Courses</h3>

            <div class="p-10 mt-20 d-flex  flex-wrap">

              {{--
                @foreach($categories as $category)
                    @if(!empty($category->subCategories) and count($category->subCategories))
                        @foreach($category->subCategories as $subCategory)
                            <div class="checkbox-button bordered-200 mt-5 mr-15">
                                <input type="checkbox" name="categories[]" id="checkbox{{ $subCategory->id }}" value="{{ $subCategory->id }}" @if(in_array($subCategory->id,request()->get('categories',[]))) checked="checked" @endif>
                                <label for="checkbox{{ $subCategory->id }}">{{ $subCategory->title }}</label>
                            </div>
                        @endforeach
                    @else
                        <div class="checkbox-button bordered-200 mr-20">
                            <input type="checkbox" name="categories[]" id="checkbox{{ $category->id }}" value="{{ $category->id }}" @if(in_array($category->id,request()->get('categories',[]))) checked="checked" @endif>
                            <label for="checkbox{{ $category->id }}">{{ $category->title }}</label>
                        </div>
                    @endif
                @endforeach
                --}}
                @foreach ($categories as $category)
                    <div class="checkbox-button bordered-200 mr-20">
                        <input type="checkbox" name="categories[]" id="checkbox{{ $category->id }}" value="{{ $category->id }}" @if(in_array($category->id,request()->get('categories',[]))) checked="checked" @endif>
                        <label for="checkbox{{ $category->id }}">{{ $category->title }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    <section class="mt-35">
        <h2 class="section-title">Tutors</h2>

        @if(!empty($users) and !$users->isEmpty())
            <div class="panel-section-card py-20 px-25 mt-20">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table custom-table text-center ">
                                <thead>
                                <tr>
                                    <th class="text-left text-gray">Tutor</th>
                                    <th class="text-left text-gray">Description</th>
                                    <th class="text-left text-gray">Institution</th>
                                    <th class="text-left text-gray">Courses</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)
                                    <tr>
                                        <td class="text-left">
                                            <div class="user-inline-avatar d-flex align-items-center">
                                                <div class="avatar bg-gray200">
                                                    <img src="{{ $user->getAvatar() }}" class="img-cover" alt="">
                                                </div>
                                                <div class=" ml-5">
                                                    <span class="d-block text-dark-blue font-weight-500">{{ $user->full_name }}</span>
                                                    <span class="mt-5 d-block font-12 {{ ($user->verified ? ' text-primary ' : ' text-warning ') }}">{{ trans('public.'.($user->verified ? 'verified' : 'not_verified')) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                           {{-- <div class="">
                                                <span class="d-block text-dark-blue font-weight-500">{{ $user->email }}</span>
                                                <span class="mt-5 d-block font-12 text-gray">id : {{ $user->id }}</span>
                                            </div> --}}
                                            <span class="text-dark-blue font-weight-500">{{ $user->about }}</span>
                                        </td>
                                        <td class="text-left">
                                          {{--  <span class="text-dark-blue font-weight-500">{{ $user->webinars->count() }}</span> --}}
                                            <span class="text-dark-blue font-weight-500">{{ $user->institution_name }}</span>
                                        </td>
                                        <td class="text-left">
                                            <span class="text-dark-blue font-weight-500">{{ $user->study_course }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="d-inline-flex align-items-center rounded py-5 px-5 font-14 btn-primary font-weight-500">
                                                <a href="{{ $user->getProfileUrl() }}{{ '?tab=appointments' }}" class="text-white">Book Tutor</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @else
            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'teachers.png',
                'title' => trans('panel.instructors_no_result'),
                'hint' =>  nl2br(trans('panel.instructors_no_result_hint')),
               // 'btn' => ['url' => '/panel/manage/instructors/new','text' => trans('panel.add_an_instructor')]
            ])
        @endif
    </section>
{{--
    <div class="my-30">
        {{ $users->appends(request()->input())->links('vendor.pagination.panel') }}
    </div>
    --}}
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/moment.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
@endpush
