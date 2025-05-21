@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    @php
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $showOtherRegisterMethod = getFeaturesSettings('show_other_register_method') ?? false;
        $showCertificateAdditionalInRegister = getFeaturesSettings('show_certificate_additional_in_register') ?? false;
        $selectRolesDuringRegistration = getFeaturesSettings('select_the_role_during_registration') ?? null;
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 pl-0">
               {{-- <img src="{{ getPageBackgroundSettings('register') }}" class="img-cover" alt="Login"> --}}
            </div>
            <div class="col-12 col-md-6">
                <div class="login-card">
                    <h1 class="font-20 font-weight-bold">{{ trans('auth.signup') }}</h1>

                    <form method="post" action="/register" enctype="multipart/form-data" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @if(!empty($selectRolesDuringRegistration) and count($selectRolesDuringRegistration))
                            <div class="form-group">
                                <label class="input-label">{{ trans('financial.account_type') }}</label>

                                <div class="d-flex align-items-center wizard-custom-radio mt-5">
                                    <div class="wizard-custom-radio-item flex-grow-1">
                                        <input type="radio" name="account_type" value="user" id="role_user" class="" checked>
                                        <label class="font-12 cursor-pointer px-15 py-10" for="role_user">{{ trans('update.role_user') }}</label>
                                    </div>

                                    @foreach($selectRolesDuringRegistration as $selectRole)
                                        <div class="wizard-custom-radio-item flex-grow-1">
                                            <input type="radio" name="account_type" value="{{ $selectRole }}" id="role_{{ $selectRole }}" class="">
                                            {{--<label class="font-12 cursor-pointer px-15 py-10" for="role_{{ $selectRole }}">{{ trans('update.role_'.$selectRole) }}</label>--}}
                                            <label class="font-12 cursor-pointer px-15 py-10" for="role_{{ $selectRole }}">Tutor</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($registerMethod == 'mobile')
                            @include('web.default.auth.register_includes.mobile_field')

                            @if($showOtherRegisterMethod)
                                @include('web.default.auth.register_includes.email_field',['optional' => true])
                            @endif
                        @else
                            @include('web.default.auth.register_includes.email_field')

                            @if($showOtherRegisterMethod)
                                @include('web.default.auth.register_includes.mobile_field',['optional' => true])
                            @endif
                        @endif

                        <div class="form-group">
                            <label class="input-label" for="full_name">{{ trans('auth.full_name') }}:</label>
                            <input name="full_name" type="text" value="{{ old('full_name') }}" class="form-control @error('full_name') is-invalid @enderror">
                            @error('full_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group position-relative">
                            <label class="input-label" for="study_course">Study Course</label>
                            <input name="study_course" id="study_course" type="text" value="{{ old('study_course') }}" class="form-control" autocomplete="off">

                            <!-- Dropdown for suggestions -->
                            <div id="courseSuggestions" class="dropdown-menu w-100" style="display: none; overflow-y: auto;"></div>
                        </div>

                        <div class="form-group position-relative">
                            <label class="input-label" for="institution_name">Institution Name</label>
                            <input name="institution_name" id="institution_name" type="text" value="{{ old('institution_name') }}" class="form-control" autocomplete="off">
                            <div id="institutionSuggestions" class="dropdown-menu w-100" style="display: none; overflow-y: auto;"></div>
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="password">{{ trans('auth.password') }}:</label>
                            <input name="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" id="password"
                                   aria-describedby="passwordHelp">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label class="input-label" for="confirm_password">{{ trans('auth.retype_password') }}:</label>
                            <input name="password_confirmation" type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror" id="confirm_password"
                                   aria-describedby="confirmPasswordHelp">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @if($showCertificateAdditionalInRegister)
                            <div class="form-group">
                                <label class="input-label" for="certificate_additional">{{ trans('update.certificate_additional') }}</label>
                                <input name="certificate_additional" id="certificate_additional" class="form-control @error('certificate_additional') is-invalid @enderror"/>
                                @error('certificate_additional')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        @endif

                        @if(getFeaturesSettings('timezone_in_register'))
                            @php
                                $selectedTimezone = getGeneralSettings('default_time_zone');
                            @endphp

                            <div class="form-group">
                                <label class="input-label">{{ trans('update.timezone') }}</label>
                                <select name="timezone" class="form-control select2" data-allow-clear="false">
                                    <option value="" {{ empty($user->timezone) ? 'selected' : '' }} disabled>{{ trans('public.select') }}</option>
                                    @foreach(getListOfTimezones() as $timezone)
                                        <option value="{{ $timezone }}" @if($selectedTimezone == $timezone) selected @endif>{{ $timezone }}</option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        @endif

                        @if(!empty($referralSettings) and $referralSettings['status'])
                            <div class="form-group ">
                                <label class="input-label" for="referral_code">{{ trans('financial.referral_code') }}:</label>
                                <input name="referral_code" type="text"
                                       class="form-control @error('referral_code') is-invalid @enderror" id="referral_code"
                                       value="{{ !empty($referralCode) ? $referralCode : old('referral_code') }}"
                                       aria-describedby="confirmPasswordHelp">
                                @error('referral_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        @endif

                        <div class="js-form-fields-card">
                            @if(!empty($formFields))
                                {!! $formFields !!}
                            @endif
                        </div>

                        <div class="teacher-fields-con">

                        </div>

                        @if(!empty(getGeneralSecuritySettings('captcha_for_register')))
                            @include('web.default.includes.captcha_input')
                        @endif

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="term" value="1" {{ (!empty(old('term')) and old('term') == '1') ? 'checked' : '' }} class="custom-control-input @error('term') is-invalid @enderror" id="term">
                            <label class="custom-control-label font-14" for="term">{{ trans('auth.i_agree_with') }}
                                <a href="pages/terms" target="_blank" class="text-secondary font-weight-bold font-14">{{ trans('auth.terms_and_rules') }}</a>
                            </label>

                            @error('term')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @error('term')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <button type="submit" class="btn btn-primary btn-block mt-20">{{ trans('auth.signup') }}</button>
                    </form>

                    <div class="text-center mt-20">
                        <span class="text-secondary">
                            {{ trans('auth.already_have_an_account') }}
                            <a href="/login" class="text-secondary font-weight-bold">{{ trans('auth.login') }}</a>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="/assets/default/js/parts/forms.min.js"></script>
    <script src="/assets/default/js/parts/register.min.js"></script>
    <script>
    $(document).ready(function () {

});
    /*    $('#study_course').on('keyup', function () {
            let query = $(this).val();

            if (query.length >= 3) { // Trigger only when 3+ characters
                $.ajax({
                    url: "/search-categories/" + query,
                    type: "GET",
                    success: function (response) {
                        let dropdown = $("#courseSuggestions");
                        dropdown.empty().show(); // Clear old results and show dropdown

                        if (response.length > 0) {
                            response.forEach(function (course) {
                                dropdown.append(
                                    `<a href="#" class="dropdown-item select-course" data-value="${course.id}">
                                        ${course.title}
                                    </a>`
                                );
                            });
                        } else {
                            dropdown.append(`<div class="dropdown-item text-muted">No results found</div>`);
                        }
                    }
                });
            } else {
                $("#courseSuggestions").hide(); // Hide dropdown if less than 3 characters
            }
        });

          // Handle selection from dropdown
          $(document).on('click', '.select-course', function (e) {
            e.preventDefault();
            let selectedTitle = $(this).text();
            $('#study_course').val(selectedTitle);
            $("#courseSuggestions").hide();
        });

        // Hide suggestions if clicked outside
        $(document).click(function (e) {
            if (!$(e.target).closest('.form-group').length) {
                $("#courseSuggestions").hide();
            }
        });
  //  });

   // $(document).ready(function () {
    $('#institution_name').on('keyup', function () {
        let query = $(this).val();

        if (query.length >= 3) { // Trigger only when 3+ characters are typed
            $.ajax({
                async: true,
                url: "/search-schools/" + query, // Adjust this route as needed
                type: "GET",
                success: function (response) {
                    let dropdown = $("#institutionSuggestions");
                    dropdown.empty().show(); // Clear previous results and show dropdown

                    if (response.length > 0) {
                        response.forEach(function (institution) {
                            dropdown.append(
                                `<a href="#" class="dropdown-item select-institution" data-value="${institution.id}">
                                    ${institution.name}
                                </a>`
                            );
                        });
                    } else {
                        dropdown.append(`<div class="dropdown-item text-muted">No results found</div>`);
                    }
                }
            });
        } else {
            $("#institutionSuggestions").hide(); // Hide dropdown if input is less than 3 characters
        }
    });

    // Handle selection from dropdown
    $(document).on('click', '.select-institution', function (e) {
        e.preventDefault();
        let selectedInstitution = $(this).text();
        $('#institution_name').val(selectedInstitution);
        $("#institutionSuggestions").hide();
    });

    // Hide suggestions if clicked outside
    $(document).click(function (e) {
        if (!$(e.target).closest('.form-group').length) {
            $("#institutionSuggestions").hide();
        }
    });
});
*/
document.addEventListener("DOMContentLoaded", function () {
    const institutionInput = document.getElementById("institution_name");
    const suggestionBox = document.getElementById("institutionSuggestions");

    institutionInput.addEventListener("keyup", async function () {
        let query = this.value.trim();

        if (query.length >= 3) {
            try {
                let response = await fetch(`/search-schools/${query}`);
                let data = await response.json();

                suggestionBox.innerHTML = ""; // Clear old results
                suggestionBox.style.display = "block"; // Show dropdown

                if (data.length > 0) {
                    data.forEach((institution) => {
                        let item = document.createElement("a");
                        item.href = "#";
                        item.className = "dropdown-item select-institution";
                        item.dataset.value = institution;
                        item.textContent = institution;
                        suggestionBox.appendChild(item);
                    });
                } else {
                    suggestionBox.innerHTML = `<div class="dropdown-item text-muted">No results found</div>`;
                }
            } catch (error) {
                console.error("Error fetching institutions:", error);
            }
        } else {
            suggestionBox.style.display = "none"; // Hide dropdown if input is too short
        }
    });

    // Handle selection from dropdown
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("select-institution")) {
            event.preventDefault();
            institutionInput.value = event.target.textContent;
            suggestionBox.style.display = "none";
        }
    });

    // Hide dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (!institutionInput.parentElement.contains(event.target)) {
            suggestionBox.style.display = "none";
        }
    });

    const studyCourseInput = document.getElementById("study_course");
    const courseSuggestions = document.getElementById("courseSuggestions");

    studyCourseInput.addEventListener("keyup", async function () {
        let query = this.value.trim();

        if (query.length >= 3) {
            try {
                let response = await fetch(`/search-categories/${query}`);
                let data = await response.json();

                courseSuggestions.innerHTML = ""; // Clear old results
                courseSuggestions.style.display = "block"; // Show dropdown

                if (data.length > 0) {
                    data.forEach((course) => {
                        let item = document.createElement("a");
                        item.href = "#";
                        item.className = "dropdown-item select-course";
                        item.dataset.value = course.id;
                        item.textContent = course.title;
                        courseSuggestions.appendChild(item);
                    });
                } else {
                    courseSuggestions.innerHTML = `<div class="dropdown-item text-muted">No results found</div>`;
                }
            } catch (error) {
                console.error("Error fetching course categories:", error);
            }
        } else {
            courseSuggestions.style.display = "none"; // Hide dropdown if input is too short
        }
    });

    // Handle selection from dropdown
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("select-course")) {
            event.preventDefault();
            studyCourseInput.value = event.target.textContent;
            courseSuggestions.style.display = "none";
        }
    });

    // Hide dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (!studyCourseInput.parentElement.contains(event.target)) {
            courseSuggestions.style.display = "none";
        }
    });
});


    </script>
@endpush
