@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <style>
        .settings-container {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
        }
        
        .settings-section {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .section-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
        }
        
        .section-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #058248, #03a65a);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        
        .section-icon i {
            color: #fff;
        }
        
        .profile-image-preview {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 1rem 0;
        }
        
        .profile-image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #e9ecef;
        }
        
        .education-card, .experience-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .education-card:hover, .experience-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .sticky-save-bar {
            position: sticky;
            bottom: 0;
            background: #fff;
            padding: 1.5rem;
            border-top: 2px solid #e9ecef;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
            z-index: 100;
            border-radius: 12px 12px 0 0;
        }
        
        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }
        
        .custom-switch .custom-control-label::before {
            background-color: #cbd5e0;
        }
        
        .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #058248;
            border-color: #058248;
        }

        .checkbox-button {
            display: inline-block;
        }
        
        .checkbox-button input[type="checkbox"] {
            display: none;
        }
        
        .checkbox-button label {
            display: inline-block;
            padding: 8px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
        }
        
        .checkbox-button input[type="checkbox"]:checked + label {
            background: linear-gradient(135deg, #058248, #03a65a);
            border-color: #058248;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="settings-container">
        <form method="post" id="userSettingForm" action="{{ (!empty($new_user)) ? '/panel/manage/'. $user_type .'/new' : '/panel/setting' }}">
            {{ csrf_field() }}
            <input type="hidden" name="step" value="all">
            <input type="hidden" name="consolidated" value="1">

            @if(!empty($organization_id))
                <input type="hidden" name="organization_id" value="{{ $organization_id }}">
                <input type="hidden" id="userId" name="user_id" value="{{ $user->id }}">
            @endif

            <!-- Profile Information Section -->
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-feather="user" width="24" height="24"></i>
                    </div>
                    <h3>{{ trans('financial.account') }}</h3>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('public.email') }}</label>
                            <input type="text" name="email" value="{{ (!empty($user) and empty($new_user)) ? $user->email : old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="{{ trans('public.email') }}"/>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('auth.name') }}</label>
                            <input type="text" name="full_name" value="{{ (!empty($user) and empty($new_user)) ? $user->full_name : old('full_name') }}" class="form-control @error('full_name') is-invalid @enderror" placeholder="{{ trans('auth.name') }}"/>
                            @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('public.mobile') }}</label>
                            <input type="tel" name="mobile" value="{{ (!empty($user) and empty($new_user)) ? $user->mobile : old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="{{ trans('public.mobile') }}"/>
                            @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if(!empty($userLanguages))
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('auth.language') }}</label>
                            <select name="language" class="form-control">
                                <option value="">{{ trans('auth.language') }}</option>
                                @foreach($userLanguages as $lang => $language)
                                    <option value="{{ $lang }}" @if(!empty($user) and mb_strtolower($user->language) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                @endforeach
                            </select>
                            @error('language')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif
{{-- 
                    @if(!empty($currencies) and count($currencies))
                        @php
                            $userCurrency = currency();
                        @endphp
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('update.currency') }}</label>
                            <select name="currency" class="form-control select2" data-allow-clear="false">
                                @foreach($currencies as $currencyItem)
                                    <option value="{{ $currencyItem->currency }}" {{ ($userCurrency == $currencyItem->currency) ? 'selected' : '' }}>{{ currenciesLists($currencyItem->currency) }} ({{ currencySign($currencyItem->currency) }})</option>
                                @endforeach
                            </select>
                            @error('currency')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @endif
 --}}
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('auth.password') }} <small class="text-muted">({{ trans('public.optional') }})</small></label>
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" placeholder="Leave blank to keep"/>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('auth.password_repeat') }}</label>
                            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ trans('auth.password_repeat') }}"/>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row mt-3">
                            {{--
                            <div class="col-md-6">
                                <div class="form-group d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                    <label class="cursor-pointer form-label mb-0" for="newsletterSwitch">
                                        <i data-feather="mail" width="18" height="18" class="mr-2"></i>
                                        {{ trans('auth.join_newsletter') }}
                                    </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="join_newsletter" class="custom-control-input" id="newsletterSwitch" {{ (!empty($user) and $user->newsletter) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="newsletterSwitch"></label>
                                    </div>
                                </div>
                            </div>
                            --}}
                            <div class="col-md-6">
                                <div class="form-group d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                    <label class="cursor-pointer form-label mb-0" for="publicMessagesSwitch">
                                        <i data-feather="message-circle" width="18" height="18" class="mr-2"></i>
                                        {{ trans('auth.public_messages') }}
                                    </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="public_messages" class="custom-control-input" id="publicMessagesSwitch" {{ (!empty($user) and $user->public_message) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="publicMessagesSwitch"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Image Section -->
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-feather="image" width="24" height="24"></i>
                    </div>
                    <h3>{{ trans('auth.profile_image') }}</h3>
                </div>

                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="text-center">
                            <div class="profile-image-preview">
                                <img src="{{ (!empty($user)) ? $user->getAvatar(150) : '' }}" alt="" id="profileImagePreview">
                            </div>

                            <button id="selectAvatarBtn" type="button" class="btn btn-primary btn-block select-image-cropit" data-ref-image="profileImagePreview" data-ref-input="profile_image">
                                <i data-feather="camera" width="18" height="18" class="mr-2"></i>
                                {{ trans('auth.select_image') }}
                            </button>

                            <input type="hidden" name="profile_image" id="profile_image" class="form-control @error('profile_image') is-invalid @enderror"/>
                            @error('profile_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-8">
                        <div class="alert alert-info">
                            <i data-feather="info" width="18" height="18" class="mr-2"></i>
                            <strong>Image Requirements:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Square images work best (1:1 ratio)</li>
                                <li>Minimum size: 150x150 pixels</li>
                                <li>Recommended size: 400x400 pixels</li>
                                <li>Maximum file size: 2MB</li>
                                <li>Supported formats: JPG, PNG</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-feather="file-text" width="24" height="24"></i>
                    </div>
                    <h3>{{ trans('site.about') }}</h3>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('panel.bio') }}</label>
                            <textarea name="about" rows="6" class="form-control @error('about') is-invalid @enderror" placeholder="{{ trans('panel.tell_us_about_yourself') }}">{!! (!empty($user) and empty($new_user)) ? $user->about : old('about') !!}</textarea>
                            @error('about')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tell students about yourself, your teaching style, and what makes you unique.</small>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Course Title</label>
                            <textarea name="bio" rows="3" class="form-control @error('bio') is-invalid @enderror" placeholder="{{ trans('panel.your_profession') }}">{{ $user->bio }}</textarea>
                            @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3 alert alert-light">
                                <small class="d-block"><strong>Tips:</strong></small>
                                <small class="d-block">• {{ trans('panel.bio_hint_1') }}</small>
                                <small class="d-block">• {{ trans('panel.bio_hint_2') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-feather="book" width="24" height="24"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3>{{ trans('site.education') }}</h3>
                    </div>
                    <button id="userAddEducations" type="button" class="btn btn-primary">
                        <i data-feather="plus" width="18" height="18" class="mr-2"></i>
                        {{ trans('site.add_education') }}
                    </button>
                </div>

                <div id="userListEducations">
                    @if(!empty($educations) and !$educations->isEmpty())
                        <div class="row">
                            @foreach($educations as $education)
                            <div class="col-12 col-md-6 mb-3">
                                <div class="education-card p-3 rounded bg-white d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <div class="mr-3">
                                            <i data-feather="award" width="24" height="24" style="color: #058248;"></i>
                                        </div>
                                        <div class="education-value font-weight-500 text-secondary">
                                            {{ $education->value }}
                                        </div>
                                    </div>
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="more-vertical" height="18"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" data-education-id="{{ $education->id }}" data-user-id="{{ (!empty($user) and empty($new_user)) ? $user->id : '' }}" class="dropdown-item edit-education">
                                                <i data-feather="edit-2" width="16" height="16" class="mr-2"></i>
                                                {{ trans('public.edit') }}
                                            </button>
                                            <a href="/panel/setting/metas/{{ $education->id }}/delete?user_id={{ (!empty($user) and empty($new_user)) ? $user->id : '' }}" class="dropdown-item delete-action text-danger">
                                                <i data-feather="trash-2" width="16" height="16" class="mr-2"></i>
                                                {{ trans('public.delete') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        @include(getTemplate() . '.includes.no-result',[
                            'file_name' => 'edu.png',
                            'title' => trans('auth.education_no_result'),
                            'hint' => trans('auth.education_no_result_hint'),
                        ])
                    @endif
                </div>
            </div>

            <!-- Experiences Section -->
            {{-- 
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-feather="briefcase" width="24" height="24"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3>{{ trans('site.experiences') }}</h3>
                    </div>
                    <button id="userAddExperiences" type="button" class="btn btn-primary">
                        <i data-feather="plus" width="18" height="18" class="mr-2"></i>
                        {{ trans('site.add_experiences') }}
                    </button>
                </div>

                <div id="userListExperiences">
                    @if(!empty($experiences) and !$experiences->isEmpty())
                        <div class="row">
                            @foreach($experiences as $experience)
                            <div class="col-12 col-md-6 mb-3">
                                <div class="experience-card p-3 rounded bg-white d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <div class="mr-3">
                                            <i data-feather="briefcase" width="24" height="24" style="color: #058248;"></i>
                                        </div>
                                        <div class="experience-value font-weight-500 text-secondary">
                                            {{ $experience->value }}
                                        </div>
                                    </div>
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="more-vertical" height="18"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" data-experience-id="{{ $experience->id }}" data-user-id="{{ (!empty($user) and empty($new_user)) ? $user->id : '' }}" class="dropdown-item edit-experience">
                                                <i data-feather="edit-2" width="16" height="16" class="mr-2"></i>
                                                {{ trans('public.edit') }}
                                            </button>
                                            <a href="/panel/setting/metas/{{ $experience->id }}/delete?user_id={{ (!empty($user) and empty($new_user)) ? $user->id : '' }}" class="dropdown-item delete-action text-danger">
                                                <i data-feather="trash-2" width="16" height="16" class="mr-2"></i>
                                                {{ trans('public.delete') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        @include(getTemplate() . '.includes.no-result',[
                            'file_name' => 'exp.png',
                            'title' => trans('auth.experience_no_result'),
                            'hint' => trans('auth.experience_no_result_hint'),
                        ])
                    @endif
                </div>
            </div>
            --}}
            <!-- Occupations Section (Only for Teachers/Tutors) -->
            @if(!$user->isUser())
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-feather="target" width="24" height="24"></i>
                    </div>
                    <h3>{{ trans('site.occupations') }}</h3>
                </div>

                <div class="d-flex align-items-center flex-wrap">
                    @foreach($categories as $category)
                        @if(!empty($category->subCategories) and count($category->subCategories))
                            @foreach($category->subCategories as $subCategory)
                                <div class="checkbox-button mr-15 mt-10">
                                    <input type="checkbox" name="occupations[]" id="checkbox{{ $subCategory->id }}" value="{{ $subCategory->id }}" @if(in_array($subCategory->id,$occupations)) checked="checked" @endif>
                                    <label class="font-14" for="checkbox{{ $subCategory->id }}">{{ $subCategory->title }}</label>
                                </div>
                            @endforeach
                        @else
                            <div class="checkbox-button mr-15 mt-10">
                                <input type="checkbox" name="occupations[]" id="checkbox{{ $category->id }}" value="{{ $category->id }}" @if(in_array($category->id,$occupations)) checked="checked" @endif>
                                <label class="font-14" for="checkbox{{ $category->id }}">{{ $category->title }}</label>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-3 alert alert-light">
                    <small class="d-block">• {{ trans('panel.interests_hint_1') }}</small>
                    <small class="d-block">• {{ trans('panel.interests_hint_2') }}</small>
                </div>
            </div>
            @endif

            <!-- Identity and Financial Section -->
            <div class="settings-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i data-feather="shield" width="24" height="24"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h3>{{ trans('site.identity_and_financial') }}</h3>
                        @if($user->financial_approval)
                            <small class="text-success d-block mt-1">
                                <i data-feather="check-circle" width="16" height="16"></i>
                                {{ trans('site.identity_and_financial_verified') }}
                            </small>
                        @else
                            <small class="text-warning d-block mt-1">
                                <i data-feather="alert-circle" width="16" height="16"></i>
                                {{ trans('site.identity_and_financial_not_verified') }}
                            </small>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label class="form-label">{{ trans('financial.select_account_type') }}</label>
                            <select name="bank_id" class="js-user-bank-input form-control @error('bank_id') is-invalid @enderror" {{ ($user->financial_approval) ? 'disabled' : '' }}>
                                <option selected disabled>{{ trans('financial.select_account_type') }}</option>

                                @foreach($userBanks as $userBank)
                                    <option value="{{ $userBank->id }}" @if(!empty($user->selectedBank) and $user->selectedBank->user_bank_id == $userBank->id) selected="selected" @endif data-specifications="{{ json_encode($userBank->specifications->pluck('name','id')->toArray()) }}">{{ $userBank->title }}</option>
                                @endforeach
                            </select>

                            @error('bank_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="js-bank-specifications-card">
                            @if(!empty($user) and !empty($user->selectedBank) and !empty($user->selectedBank->bank))
                                @foreach($user->selectedBank->bank->specifications as $specification)
                                    @php
                                        $selectedBankSpecification = $user->selectedBank->specifications->where('user_selected_bank_id', $user->selectedBank->id)->where('user_bank_specification_id', $specification->id)->first();
                                    @endphp
                                    <div class="form-group">
                                        <label class="form-label">{{ $specification->name }}</label>
                                        <input type="text" name="bank_specifications[{{ $specification->id }}]" value="{{ (!empty($selectedBankSpecification)) ? $selectedBankSpecification->value : '' }}" class="form-control" {{ ($user->financial_approval) ? 'disabled' : '' }}/>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ trans('financial.identity_scan') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="input-group-text {{ ($user->financial_approval) ? '' : 'panel-file-manager' }}" data-input="identity_scan" data-preview="holder">
                                        <i data-feather="upload" width="18" height="18" class="text-white"></i>
                                    </button>
                                </div>
                                <input type="text" name="identity_scan" id="identity_scan" value="{{ (!empty($user) and empty($new_user)) ? $user->identity_scan : old('identity_scan') }}" class="form-control @error('identity_scan') is-invalid @enderror" {{ ($user->financial_approval) ? 'disabled' : '' }}/>
                                @error('identity_scan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ trans('public.certificate_and_documents') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="input-group-text panel-file-manager" data-input="certificate" data-preview="holder">
                                        <i data-feather="upload" width="18" height="18" class="text-white"></i>
                                    </button>
                                </div>
                                <input type="text" name="certificate" id="certificate" value="{{ (!empty($user) and empty($new_user)) ? $user->certificate : old('certificate') }}" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ trans('financial.address') }}</label>
                            <input type="text" name="address" value="{{ (!empty($user) and empty($new_user)) ? $user->address : old('address') }}" class="form-control @error('address') is-invalid @enderror" placeholder="{{ trans('financial.address') }}"/>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- Sticky Save Bar -->
    <div class="sticky-save-bar">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                @if(empty($new_user) and empty($edit_new_user))
                    <a href="/panel/setting/deleteAccount" class="delete-action btn btn-outline-danger" data-confirm="{{ trans('update.delete_account_modal_confirm_btn_text') }}" data-title="{{ trans('update.delete_account_modal_hint') }}">
                        <i data-feather="trash-2" width="18" height="18" class="mr-2"></i>
                        {{ trans('update.delete_account') }}
                    </a>
                @endif
            </div>

            <div>
                <button type="button" id="saveData" class="btn btn-primary btn-lg">
                    <i data-feather="save" width="18" height="18" class="mr-2"></i>
                    {{ trans('public.save_changes') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Image Crop Modal -->
    <div class="modal fade" id="avatarCropModalContainer" tabindex="-1" role="dialog" aria-labelledby="avatarCrop">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ trans('public.edit_selected_image') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="imageCropperContainer">
                        <div class="cropit-preview"></div>
                        <div class="cropit-tools">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="mr-20">
                                    <button type="button" class="btn btn-light rotate-cw mr-10">
                                        <i data-feather="rotate-cw" width="18" height="18"></i>
                                    </button>
                                    <button type="button" class="btn btn-light rotate-ccw">
                                        <i data-feather="rotate-ccw" width="18" height="18"></i>
                                    </button>
                                </div>

                                <div class="d-flex align-items-center justify-content-center">
                                    <span>-</span>
                                    <input type="range" class="cropit-image-zoom-input mx-10">
                                    <span>+</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-secondary" id="cancelAvatarCrop">{{ trans('public.cancel') }}</button>
                            <button class="btn btn-primary" id="storeAvatar">{{ trans('public.select') }}</button>
                        </div>
                        <input type="file" class="cropit-image-input">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Education Modal -->
    <div class="d-none" id="newEducationModal">
        <h3 class="section-title after-line">{{ trans('site.new_education') }}</h3>
        <div class="mt-20 text-center">
            <img src="/assets/default/img/info.png" width="108" height="96" class="rounded-circle" alt="">
            <h4 class="font-16 mt-20 text-dark-blue font-weight-bold">{{ trans('site.new_education_hint') }}</h4>
            <span class="d-block mt-10 text-gray font-14">{{ trans('site.new_education_exam') }}</span>
            <div class="form-group mt-15 px-50">
                <input type="text" id="new_education_val" class="form-control" placeholder="e.g., BSc Computer Science - University of Cape Town">
                <div class="invalid-feedback">{{ trans('validation.required',['attribute' => 'value']) }}</div>
            </div>
        </div>

        <div class="mt-30 d-flex align-items-center justify-content-end">
            <button type="button" id="saveEducation" class="btn btn-primary">{{ trans('public.save') }}</button>
            <button type="button" class="btn btn-secondary ml-10 close-swl">{{ trans('public.close') }}</button>
        </div>
    </div>

    <!-- Experience Modal -->
    <div class="d-none" id="newExperienceModal">
        <h3 class="section-title after-line">{{ trans('site.new_experience') }}</h3>
        <div class="mt-20 text-center">
            <img src="/assets/default/img/info.png" width="108" height="96" class="rounded-circle" alt="">
            <h4 class="font-16 mt-20 text-dark-blue font-weight-bold">{{ trans('site.new_experience_hint') }}</h4>
            <span class="d-block mt-10 text-gray font-14">{{ trans('site.new_experience_exam') }}</span>
            <div class="form-group mt-15 px-50">
                <input type="text" id="new_experience_val" class="form-control" placeholder="e.g., Math Tutor at ABC Learning Center - 2 years">
                <div class="invalid-feedback">{{ trans('validation.required',['attribute' => 'value']) }}</div>
            </div>
        </div>

        <div class="mt-30 d-flex align-items-center justify-content-end">
            <button type="button" id="saveExperience" class="btn btn-primary">{{ trans('public.save') }}</button>
            <button type="button" class="btn btn-secondary ml-10 close-swl">{{ trans('public.close') }}</button>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/vendors/cropit/jquery.cropit.js"></script>
    <script src="/assets/default/js/parts/img_cropit.min.js"></script>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>

    <script>
        var editEducationLang = '{{ trans('site.edit_education') }}';
        var editExperienceLang = '{{ trans('site.edit_experience') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var saveErrorLang = '{{ trans('site.store_error_try_again') }}';
        var notAccessToLang = '{{ trans('public.not_access_to_this_content') }}';
    </script>

    <script src="/assets/default/js/panel/user_setting.min.js"></script>
@endpush