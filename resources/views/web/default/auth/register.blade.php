@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <style>
        .autocomplete-dropdown {
            position: absolute;
            z-index: 1000;
            width: 100%;
            max-height: 220px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 .25rem .25rem;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,.08);
            display: none;
        }
        .autocomplete-dropdown .dropdown-item {
            padding: .45rem .75rem;
            cursor: pointer;
            font-size: .9rem;
        }
        .autocomplete-dropdown .dropdown-item:hover,
        .autocomplete-dropdown .dropdown-item.active {
            background-color: #f0f4ff;
            color: #333;
        }
        .autocomplete-dropdown .dropdown-item.no-results {
            color: #aaa;
            cursor: default;
            pointer-events: none;
        }
        .autocomplete-dropdown .dropdown-item .badge-type {
            font-size: .7rem;
            margin-left: .4rem;
            vertical-align: middle;
            opacity: .7;
        }
    </style>
@endpush

@section('content')
    @php
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $showOtherRegisterMethod = getFeaturesSettings('show_other_register_method') ?? false;
        $showCertificateAdditionalInRegister = getFeaturesSettings('show_certificate_additional_in_register') ?? false;
        $selectRolesDuringRegistration = getFeaturesSettings('select_the_role_during_registration') ?? null;

        // $institutionsForJs is passed by the controller (RegisterController::showRegistrationForm)
        // from the static institutions.json. No file I/O needed here.
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

                        {{-- Account type --}}
                        @if(!empty($selectRolesDuringRegistration) and count($selectRolesDuringRegistration))
                            <div class="form-group">
                                <label class="input-label">{{ trans('financial.account_type') }}</label>
                                <div class="d-flex align-items-center wizard-custom-radio mt-5">
                                    <div class="wizard-custom-radio-item flex-grow-1">
                                        <input type="radio" name="account_type" value="user" id="role_user" checked>
                                        <label class="font-12 cursor-pointer px-15 py-10" for="role_user">{{ trans('update.role_user') }}</label>
                                    </div>
                                    @foreach($selectRolesDuringRegistration as $selectRole)
                                        <div class="wizard-custom-radio-item flex-grow-1">
                                            <input type="radio" name="account_type" value="{{ $selectRole }}" id="role_{{ $selectRole }}">
                                            <label class="font-12 cursor-pointer px-15 py-10" for="role_{{ $selectRole }}">Tutor</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Mobile / Email --}}
                        @if($registerMethod == 'mobile')
                            @include('web.default.auth.register_includes.mobile_field')
                            @if($showOtherRegisterMethod)
                                @include('web.default.auth.register_includes.email_field', ['optional' => true])
                            @endif
                        @else
                            @include('web.default.auth.register_includes.email_field')
                            @if($showOtherRegisterMethod)
                                @include('web.default.auth.register_includes.mobile_field', ['optional' => true])
                            @endif
                        @endif

                        {{-- Full name --}}
                        <div class="form-group">
                            <label class="input-label" for="full_name">{{ trans('auth.full_name') }}:</label>
                            <input name="full_name" id="full_name" type="text" value="{{ old('full_name') }}"
                                   class="form-control @error('full_name') is-invalid @enderror">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Study course (AJAX against /search-categories) --}}
                        <div class="form-group position-relative">
                            <label class="input-label" for="study_course">Study Course</label>
                            <input name="study_course" id="study_course" type="text"
                                   value="{{ old('study_course') }}"
                                   class="form-control"
                                   autocomplete="off"
                                   role="combobox"
                                   aria-autocomplete="list"
                                   aria-expanded="false"
                                   aria-controls="courseSuggestions">
                            <div id="courseSuggestions"
                                 class="autocomplete-dropdown"
                                 role="listbox"
                                 aria-label="Course suggestions"></div>
                        </div>

                        {{-- Institution — powered by inline JSON, no HTTP request needed --}}
                        <div class="form-group position-relative">
                            <label class="input-label" for="institution_name">Institution Name</label>
                            <input name="institution_name" id="institution_name" type="text"
                                   value="{{ old('institution_name') }}"
                                   class="form-control"
                                   autocomplete="off"
                                   role="combobox"
                                   aria-autocomplete="list"
                                   aria-expanded="false"
                                   aria-controls="institutionSuggestions">
                            <div id="institutionSuggestions"
                                 class="autocomplete-dropdown"
                                 role="listbox"
                                 aria-label="Institution suggestions"></div>
                        </div>

                        {{-- ID Number --}}
                        <div class="form-group">
                            <label class="input-label" for="id_number">ID Number</label>
                            <input name="id_number" id="id_number" type="text"
                                   value="{{ old('id_number') }}"
                                   class="form-control @error('id_number') is-invalid @enderror"
                                   maxlength="13">
                            @error('id_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-group">
                            <label class="input-label" for="password">{{ trans('auth.password') }}:</label>
                            <input name="password" id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   aria-describedby="passwordHelp">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="confirm_password">{{ trans('auth.retype_password') }}:</label>
                            <input name="password_confirmation" id="confirm_password" type="password"
                                   class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($showCertificateAdditionalInRegister)
                            <div class="form-group">
                                <label class="input-label" for="certificate_additional">{{ trans('update.certificate_additional') }}</label>
                                <input name="certificate_additional" id="certificate_additional"
                                       class="form-control @error('certificate_additional') is-invalid @enderror"/>
                                @error('certificate_additional')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        @if(!empty($referralSettings) and $referralSettings['status'])
                            <div class="form-group">
                                <label class="input-label" for="referral_code">{{ trans('financial.referral_code') }}:</label>
                                <input name="referral_code" id="referral_code" type="text"
                                       class="form-control @error('referral_code') is-invalid @enderror"
                                       value="{{ !empty($referralCode) ? $referralCode : old('referral_code') }}">
                                @error('referral_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="js-form-fields-card">
                            @if(!empty($formFields))
                                {!! $formFields !!}
                            @endif
                        </div>

                        <div class="teacher-fields-con"></div>

                        @if(!empty(getGeneralSecuritySettings('captcha_for_register')))
                            @include('web.default.includes.captcha_input')
                        @endif

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="term" value="1"
                                   {{ (!empty(old('term')) and old('term') == '1') ? 'checked' : '' }}
                                   class="custom-control-input @error('term') is-invalid @enderror"
                                   id="term">
                            <label class="custom-control-label font-14" for="term">
                                {{ trans('auth.i_agree_with') }}
                                <a href="pages/terms" target="_blank" class="text-secondary font-weight-bold font-14">
                                    {{ trans('auth.terms_and_rules') }}
                                </a>
                            </label>
                            @error('term')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-20">
                            {{ trans('auth.signup') }}
                        </button>
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

    {{-- Inline the institution list from the JSON — no HTTP round-trip required --}}
    <script>
    const INSTITUTIONS = @json($institutionsForJs);
    </script>

    <script>
    (function () {
        'use strict';

        /* ------------------------------------------------------------------ *
         *  Generic autocomplete factory
         *  Supports:
         *   - static array  (staticItems)
         *   - async fetcher (fetchFn)      async (query) => [{label, meta?}]
         *   - keyboard navigation (↑ ↓ Enter Escape)
         * ------------------------------------------------------------------ */
        function makeAutocomplete({ inputEl, dropdownEl, staticItems, fetchFn, minChars = 2 }) {
            let activeIndex = -1;
            let lastQuery   = '';
            let debounceTimer;

            function getItems() {
                return Array.from(dropdownEl.querySelectorAll('.dropdown-item:not(.no-results)'));
            }

            function highlight(index) {
                getItems().forEach((el, i) => el.classList.toggle('active', i === index));
                activeIndex = index;
            }

            function close() {
                dropdownEl.style.display = 'none';
                activeIndex = -1;
                inputEl.setAttribute('aria-expanded', 'false');
            }

            function open() {
                dropdownEl.style.display = 'block';
                inputEl.setAttribute('aria-expanded', 'true');
            }

            function render(results) {
                dropdownEl.innerHTML = '';
                activeIndex = -1;

                if (!results.length) {
                    const empty = document.createElement('div');
                    empty.className = 'dropdown-item no-results';
                    empty.textContent = 'No results found';
                    dropdownEl.appendChild(empty);
                } else {
                    results.forEach(({ label, meta }) => {
                        const a = document.createElement('a');
                        a.href = '#';
                        a.className = 'dropdown-item';
                        a.setAttribute('role', 'option');
                        a.textContent = label;
                        if (meta) {
                            const badge = document.createElement('span');
                            badge.className = 'badge badge-secondary badge-type';
                            badge.textContent = meta;
                            a.appendChild(badge);
                        }
                        a.addEventListener('mousedown', function (e) {
                            // mousedown fires before blur — prevent the field losing focus first
                            e.preventDefault();
                            inputEl.value = label;
                            close();
                        });
                        dropdownEl.appendChild(a);
                    });
                }
                open();
            }

            async function search(query) {
                if (staticItems) {
                    const q = query.toLowerCase();
                    return staticItems
                        .filter(item => item.name.toLowerCase().includes(q))
                        .slice(0, 30)
                        .map(item => ({ label: item.name, meta: item.type }));
                }
                if (fetchFn) {
                    return fetchFn(query);
                }
                return [];
            }

            inputEl.addEventListener('input', function () {
                const query = this.value.trim();
                clearTimeout(debounceTimer);

                if (query.length < minChars) {
                    close();
                    return;
                }
                if (query === lastQuery) return;
                lastQuery = query;

                debounceTimer = setTimeout(async () => {
                    const results = await search(query);
                    render(results);
                }, staticItems ? 0 : 200); // no debounce needed for local data
            });

            inputEl.addEventListener('keydown', function (e) {
                const items = getItems();
                if (!items.length) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    highlight(Math.min(activeIndex + 1, items.length - 1));
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    highlight(Math.max(activeIndex - 1, 0));
                } else if (e.key === 'Enter') {
                    if (activeIndex >= 0 && items[activeIndex]) {
                        e.preventDefault();
                        inputEl.value = items[activeIndex].textContent.trim();
                        close();
                    }
                } else if (e.key === 'Escape') {
                    close();
                }
            });

            inputEl.addEventListener('blur', function () {
                // Small delay so mousedown on a dropdown item fires first
                setTimeout(close, 150);
            });
        }

        /* ------------------------------------------------------------------ *
         *  Institution autocomplete — uses inline JSON (no HTTP request)
         * ------------------------------------------------------------------ */
        makeAutocomplete({
            inputEl:     document.getElementById('institution_name'),
            dropdownEl:  document.getElementById('institutionSuggestions'),
            staticItems: INSTITUTIONS,   // injected by the blade above
            minChars:    2,
        });

        /* ------------------------------------------------------------------ *
         *  Study-course autocomplete — fetches from /search-categories/{q}
         * ------------------------------------------------------------------ */
        makeAutocomplete({
            inputEl:    document.getElementById('study_course'),
            dropdownEl: document.getElementById('courseSuggestions'),
            minChars:   3,
            fetchFn:    async (query) => {
                const res  = await fetch(`/search-categories/${encodeURIComponent(query)}`);
                const data = await res.json();
                return (data || []).map(c => ({ label: c.title, meta: null }));
            },
        });

    })();
    </script>
@endpush