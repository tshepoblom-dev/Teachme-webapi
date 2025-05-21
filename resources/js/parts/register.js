(function () {
    "use strict"

    $('body').on('change', 'input[name="account_type"]', function () {
        const value = $(this).val();
        $.post('/register/form-fields', {type: value}, function (result) {
            if (result) {
                $('.js-form-fields-card').html(result.html);

                formsDatetimepicker();

                feather.replace();
            }
        })
    })

    $('body').on('click', "#role_teacher", function () {
        let fieldsHtml = `
            <div class="teacher-fields">
                <div class="form-group">
                    <label class="js-instructor-label font-weight-500 text-dark-blue">Instructor Certificate and Documents</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="input-group-text" data-input="certificate" data-preview="holder">
                                <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                            </button>
                        </div>
                        <input type="file" name="certificate" id="certificate" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="js-instructor-label font-weight-500 text-dark-blue">Instructor Identity Scan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="input-group-text" data-input="identity_scan" data-preview="holder">
                                <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                            </button>
                        </div>
                        <input type="file" name="identity_scan" id="identity_scan" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="js-instructor-label font-weight-500 text-dark-blue">Instructor CV</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="input-group-text" data-input="cv" data-preview="holder">
                                <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                            </button>
                        </div>
                        <input type="file" name="cv" id="cv" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="js-instructor-label font-weight-500 text-dark-blue">Instructor POA</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="button" class="input-group-text" data-input="poa" data-preview="holder">
                                <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                            </button>
                        </div>
                        <input type="file" name="poa" id="poa" class="form-control"/>
                    </div>
                </div>
            </div>
        `;

      //  console.log(fieldsHtml);
        // Append fields if they are not already added
        $('.teacher-fields-con').html(fieldsHtml);

    });
    $('body').on('click', "#role_user", function () {
        $('.teacher-fields').remove();
    });
})(jQuery)
