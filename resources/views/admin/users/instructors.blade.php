@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.instructors') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">{{ trans('admin/main.instructors') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.users') }}</div>
            </div>
        </div>
    </section>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.total_instructors') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalInstructors }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-briefcase"></i></div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.organizations_instructors') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalOrganizationsInstructors }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-info-circle"></i></div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.inactive_instructors') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $inactiveInstructors }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-ban"></i></div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ trans('admin/main.ban_instructors') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $banInstructors }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="card">
            <div class="card-body">
                <form method="get" class="mb-0">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.search') }}</label>
                                <input name="full_name" type="text" class="form-control" value="{{ request()->get('full_name') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                                <div class="input-group">
                                    <input type="date" id="from" class="text-center form-control" name="from" value="{{ request()->get('from') }}" placeholder="Start Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                                <div class="input-group">
                                    <input type="date" id="to" class="text-center form-control" name="to" value="{{ request()->get('to') }}" placeholder="End Date">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.filters') }}</label>
                                <select name="sort" data-plugin-selectTwo class="form-control populate">
                                    <option value="">{{ trans('admin/main.filter_type') }}</option>
                                    <option value="sales_classes_asc" @if(request()->get('sort') == 'sales_classes_asc') selected @endif>{{ trans('admin/main.classes_sales_ascending') }}</option>
                                    <option value="sales_classes_desc" @if(request()->get('sort') == 'sales_classes_desc') selected @endif>{{ trans('admin/main.classes_sales_descending') }}</option>
                                    <option value="purchased_classes_asc" @if(request()->get('sort') == 'purchased_asc') selected @endif>{{ trans('admin/main.purchased_classes_ascending') }}</option>
                                    <option value="purchased_classes_desc" @if(request()->get('sort') == 'purchased_desc') selected @endif>{{ trans('admin/main.purchased_classes_descending') }}</option>
                                    <option value="sales_appointments_asc" @if(request()->get('sort') == 'appointments_asc') selected @endif>{{ trans('admin/main.sales_appointments_ascending') }}</option>
                                    <option value="sales_appointments_desc" @if(request()->get('sort') == 'appointments_desc') selected @endif> {{ trans('admin/main.sales_appointments_descending') }}</option>
                                    <option value="purchased_appointments_asc" @if(request()->get('sort') == 'purchased_appointments_asc') selected @endif>{{ trans('admin/main.purchased_appointments_ascending') }}</option>
                                    <option value="purchased_appointments_desc" @if(request()->get('sort') == 'purchased_appointments_desc') selected @endif>{{ trans('admin/main.purchased_appointments_descending') }}</option>
                                    <option value="register_asc" @if(request()->get('sort') == 'register_asc') selected @endif>{{ trans('admin/main.register_date_ascending') }}</option>
                                    <option value="register_desc" @if(request()->get('sort') == 'register_desc') selected @endif>{{ trans('admin/main.register_date_descending') }}</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.organization') }}</label>
                                <select name="organization_id" data-plugin-selectTwo class="form-control populate">
                                    <option value="">{{ trans('admin/main.select_organization') }}</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" @if(request()->get('organization_id') == $organization->id) selected @endif>{{ $organization->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.user_group') }}</label>
                                <select name="group_id" data-plugin-selectTwo class="form-control populate">
                                    <option value="">{{ trans('admin/main.select_users_group') }}</option>
                                    @foreach($userGroups as $userGroup)
                                        <option value="{{ $userGroup->id }}" @if(request()->get('group_id') == $userGroup->id) selected @endif>{{ $userGroup->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label">{{ trans('admin/main.status') }}</label>
                                <select name="status" data-plugin-selectTwo class="form-control populate">
                                    <option value="">{{ trans('admin/main.all_status') }}</option>
                                    <option value="active_verified" @if(request()->get('status') == 'active_verified') selected @endif>{{ trans('admin/main.active_verified') }}</option>
                                    <option value="active_notVerified" @if(request()->get('status') == 'active_notVerified') selected @endif>{{ trans('admin/main.active_not_verified') }}</option>
                                    <option value="inactive" @if(request()->get('status') == 'inactive') selected @endif>{{ trans('admin/main.inactive') }}</option>
                                    <option value="ban" @if(request()->get('status') == 'ban') selected @endif>{{ trans('admin/main.banned') }}</option>
                                    <option value="has_uploads" @if(request()->get('status') == 'has_uploads') selected @endif>Has Uploaded Documents</option>
                                    <option value="pending_verification" @if(request()->get('status') == 'pending_verification') selected @endif>Pending Verification (active, not verified)</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group mt-1">
                                <label class="input-label mb-4"> </label>
                                <input type="submit" class="text-center btn btn-primary w-100" value="{{ trans('admin/main.show_results') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div class="card">
        <div class="card-header">
            @can('admin_users_export_excel')
                <a href="{{ getAdminPanelUrl() }}/instructors/excel?{{ http_build_query(request()->all()) }}" class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
            @endcan
            <div class="h-10"></div>
        </div>

        <div class="card-body">
            <div class="table-responsive text-center">
                <table class="table table-striped font-14">
                    <tr>
                        <th>{{ trans('admin/main.id') }}</th>
                        <th>{{ trans('admin/main.name') }}</th>
                        <th>{{ trans('admin/main.classes_sales') }}</th>
                        <th>{{ trans('admin/main.appointments_sales') }}</th>
                        <th>{{ trans('admin/main.purchased_classes') }}</th>
                        <th>{{ trans('admin/main.purchased_appointments') }}</th>
                        <th>{{ trans('admin/main.wallet_charge') }}</th>
                        <th>{{ trans('admin/main.user_group') }}</th>
                        <th>{{ trans('admin/main.register_date') }}</th>
                        <th>{{ trans('admin/main.status') }}</th>
                        <th>Documents</th>
                        <th width="120">{{ trans('admin/main.actions') }}</th>
                    </tr>

                    @php
    /**
     * Convert the stored DB path to a working public URL.
     *
     * The upload manager stores paths like "/storage/store/1087//file.pdf"
     * but files live under public/store/, so the correct URL is "/store/1087/file.pdf".
     * Steps:
     *   1. Strip a leading /storage prefix if present (artefact of the storage_path value)
     *   2. Collapse any double slashes caused by path joining bugs
     *   3. Build a full URL with url()
     */
    if (!function_exists('docFileUrl')) {
        function docFileUrl(string $storedPath): string {
            // Collapse any consecutive slashes (e.g. store/1087//file.pdf)
            $path = preg_replace('#/+#', '/', $storedPath);
            return url(ltrim($path, '/'));
        }
    }
@endphp

@foreach($users as $user)

                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="text-left">
                                <div class="d-flex align-items-center">
                                    <figure class="avatar mr-2">
                                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->full_name }}">
                                    </figure>
                                    <div class="media-body ml-1">
                                        <div class="mt-0 mb-1 font-weight-bold">{{ $user->full_name }}</div>

                                        @if($user->mobile)
                                            <div class="text-primary text-small font-600-bold">{{ $user->mobile }}</div>
                                        @endif

                                        @if($user->email)
                                            <div class="text-primary text-small font-600-bold">{{ $user->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="media-body">
                                    <div class="text-primary mt-0 mb-1 font-weight-bold">{{ $user->classesSalesCount }}</div>
                                    <div class="text-small font-600-bold">{{ handlePrice($user->classesSalesSum) }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="media-body">
                                    <div class="text-primary mt-0 mb-1 font-weight-bold">{{ $user->meetingsSalesCount }}</div>
                                    <div class="text-small font-600-bold">{{ handlePrice($user->meetingsSalesSum) }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="media-body">
                                    <div class="text-primary mt-0 mb-1 font-weight-bold">{{ $user->classesPurchasedsCount }}</div>
                                    <div class="text-small font-600-bold">{{ handlePrice($user->classesPurchasedsSum) }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="media-body">
                                    <div class="text-primary mt-0 mb-1 font-weight-bold">{{ $user->meetingsPurchasedsCount }}</div>
                                    <div class="text-small font-600-bold">{{ handlePrice($user->meetingsPurchasedsSum) }}</div>
                                </div>
                            </td>

                            <td>{{ handlePrice($user->getAccountingBalance()) }}</td>

                            <td>
                                {{ !empty($user->userGroup) ? $user->userGroup->group->name : '' }}
                            </td>

                            <td>{{ dateTimeFormat($user->created_at, 'j M Y - H:i') }}</td>

                            <td>
                                <div class="media-body">
                                    @if($user->ban and !empty($user->ban_end_at) and $user->ban_end_at > time())
                                        <div class="mt-0 mb-1 font-weight-bold text-danger">{{ trans('admin/main.banned') }}</div>
                                        <div class="text-small font-600-bold">{{ trans('admin/main.until') }} {{ dateTimeFormat($user->ban_end_at, 'j M Y') }}</div>
                                    @else
                                        <div class="mt-0 mb-1 font-weight-bold {{ ($user->status == 'active') ? 'text-success' : 'text-warning' }}">{{ trans('admin/main.'.$user->status) }}</div>
                                        <div class="text-small font-600-bold {{ ($user->verified ? ' text-success ' : ' text-warning ') }}">({{ trans('admin/main.'.($user->verified ? 'verified' : 'not_verified')) }})</div>
                                    @endif
                                </div>
                            </td>
                            {{-- Documents column --}}
                            @php
                                $docFields = [
                                    'identity_scan'    => 'ID',
                                    'certificate'      => 'Cert',
                                    'cvdoc'            => 'CV',
                                    'proofofaddress'   => 'PoA',
                                    'bankconfirmation' => 'Bank',
                                ];
                                $uploadCount = collect($docFields)->filter(fn($label, $col) => !empty($user->$col))->count();
                            @endphp
                            <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center gap-1 mb-1">
                                    @foreach($docFields as $col => $label)
                                        <span class="badge {{ !empty($user->$col) ? 'badge-success' : 'badge-secondary' }}"
                                              title="{{ $col }}"
                                              style="font-size:.65rem;">{{ $label }}</span>
                                    @endforeach
                                </div>
                                @if($uploadCount > 0)
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary btn-view-docs mt-1"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->full_name }}"
                                            data-institution="{{ $user->institution_name ?? '' }}"
                                            data-course="{{ $user->study_course ?? '' }}"
                                            data-idnumber="{{ $user->id_number ?? '' }}"
                                            data-identity="{{ $user->identity_scan    ? docFileUrl($user->identity_scan)    : '' }}"
                                            data-certificate="{{ $user->certificate   ? docFileUrl($user->certificate)      : '' }}"
                                            data-cv="{{ $user->cvdoc                  ? docFileUrl($user->cvdoc)            : '' }}"
                                            data-poa="{{ $user->proofofaddress        ? docFileUrl($user->proofofaddress)   : '' }}"
                                            data-bank="{{ $user->bankconfirmation     ? docFileUrl($user->bankconfirmation) : '' }}"
                                            data-toggle="modal"
                                            data-target="#docsModal">
                                        <i class="fa fa-folder-open mr-1"></i>{{ $uploadCount }}/{{ count($docFields) }}
                                    </button>
                                @else
                                    <span class="text-muted text-small">None</span>
                                @endif
                            </td>

                            <td class="text-center mb-2" width="120">
                                @can('admin_users_impersonate')
                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/impersonate" target="_blank" class="btn-transparent  text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.login') }}">
                                        <i class="fa fa-user-shield"></i>
                                    </a>
                                @endcan

                                @can('admin_users_edit')
                                    <a href="{{ getAdminPanelUrl() }}/users/{{ $user->id }}/edit" class="btn-transparent  text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan

                                @can('admin_users_delete')
                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/users/'.$user->id.'/delete' , 'btnClass' => '', 'deleteConfirmMsg' => trans('update.user_delete_confirm_msg')])
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="card-footer text-center">
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>


    <section class="card">
        <div class="card-body">
            <div class="section-title ml-0 mt-0 mb-3"><h4>{{trans('admin/main.hints')}}</h4></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">{{ trans('admin/main.instructors_hint_title_1') }}</div>
                        <div class=" text-small font-600-bold mb-2">{{ trans('admin/main.instructors_hint_description_1') }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">{{ trans('admin/main.instructors_hint_title_2') }}</div>
                        <div class=" text-small font-600-bold mb-2">{{ trans('admin/main.instructors_hint_description_2') }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">{{ trans('admin/main.instructors_hint_title_3') }}</div>
                        <div class="text-small font-600-bold mb-2">{{ trans('admin/main.instructors_hint_description_3') }}</div>
                    </div>
                </div>


            </div>
        </div>
    </section>
{{-- ================================================================ --}}
{{-- Document viewer modal                                             --}}
{{-- ================================================================ --}}
<div class="modal fade" id="docsModal" tabindex="-1" role="dialog" aria-labelledby="docsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="docsModalLabel">Documents &mdash; <span id="docsModalName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Registration profile fields --}}
                <div class="row mb-3 pb-3 border-bottom">
                    <div class="col-md-4">
                        <p class="mb-1 text-muted text-small">Institution</p>
                        <p class="font-weight-bold" id="docsInstitution">—</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted text-small">Study Course</p>
                        <p class="font-weight-bold" id="docsCourse">—</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted text-small">ID Number</p>
                        <p class="font-weight-bold" id="docsIdNumber">—</p>
                    </div>
                </div>

                {{-- Document links --}}
                <div class="row" id="docsFileList">
                    {{-- Populated by JS --}}
                </div>
            </div>
            <div class="modal-footer">
                <a id="docsEditLink" href="#" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit mr-1"></i> Edit User
                </a>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    // Map data-* attribute names to human-readable labels and icon classes
    const DOC_MAP = [
        { key: 'identity',    label: 'ID Document',          icon: 'fa-id-card' },
        { key: 'certificate', label: 'Qualification / Cert', icon: 'fa-graduation-cap' },
        { key: 'cv',          label: 'CV / Résumé',          icon: 'fa-file-alt' },
        { key: 'poa',         label: 'Proof of Address',     icon: 'fa-home' },
        { key: 'bank',        label: 'Bank Account Letter',  icon: 'fa-university' },
    ];

    const adminBase = '{{ getAdminPanelUrl() }}';

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-view-docs');
        if (!btn) return;

        const d = btn.dataset;

        // Header
        document.getElementById('docsModalName').textContent = d.userName || '—';

        // Profile fields
        document.getElementById('docsInstitution').textContent = d.institution || '—';
        document.getElementById('docsCourse').textContent      = d.course      || '—';
        document.getElementById('docsIdNumber').textContent    = d.idnumber    || '—';

        // Edit link
        document.getElementById('docsEditLink').href = adminBase + '/users/' + d.userId + '/edit';

        // Build document cards
        const list = document.getElementById('docsFileList');
        list.innerHTML = '';

        DOC_MAP.forEach(function (doc) {
            const url = d[doc.key] || '';
            const hasFile = url.length > 0;
            const isPdf   = hasFile && url.toLowerCase().endsWith('.pdf');

            const col = document.createElement('div');
            col.className = 'col-md-4 mb-3';

            if (hasFile) {
                // For images render a thumbnail; for PDFs show an icon link
                const preview = isPdf
                    ? `<div class="text-center py-3"><i class="fa fa-file-pdf fa-3x text-danger"></i></div>`
                    : `<img src="${url}" alt="${doc.label}" class="img-fluid rounded mb-2"
                           style="max-height:140px;object-fit:cover;width:100%"
                           onerror="this.style.display='none'">`;

                col.innerHTML = `
                    <div class="card border h-100">
                        <div class="card-body p-2 text-center">
                            ${preview}
                            <p class="mb-1 font-weight-bold text-small">${doc.label}</p>
                            <a href="${url}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-external-link-alt mr-1"></i>Open
                            </a>
                        </div>
                    </div>`;
            } else {
                col.innerHTML = `
                    <div class="card border border-dashed h-100 bg-light">
                        <div class="card-body p-2 text-center text-muted">
                            <i class="fa fa-${doc.icon} fa-2x mb-2 d-block opacity-50"></i>
                            <p class="mb-0 text-small">${doc.label}</p>
                            <small>Not uploaded</small>
                        </div>
                    </div>`;
            }

            list.appendChild(col);
        });
    });
})();
</script>

@endsection