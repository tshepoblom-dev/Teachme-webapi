(function ($) {
    "use strict";
 $('body').on('click', '.js-finish-meeting-reserve', function (e) {
        e.preventDefault();

        const reserve_id = $(this).attr('data-id');
        const action = '/panel/meetings/' + reserve_id + '/finish';
/*
        var html = '<div class="">\n' +
            '    <p class="">' + finishReserveHint + '</p>\n' +
            '    <div class="mt-30 d-flex align-items-center justify-content-center">\n' +
            '        <button type="button" id="finishReserve" data-href="' + action + '" class="btn btn-sm btn-primary">' + finishReserveConfirm + '</button>\n' +
            '        <button type="button" class="btn btn-sm btn-danger ml-10 close-swl">' + finishReserveCancel + '</button>\n' +
            '    </div>\n' +
            '</div>';
*/
        var html = '<div class="">\n' +
        '    <p class="">' + finishReserveHint + '</p>\n' +
        '    <label for="finishReason" class="d-block mt-10">Reason for finishing the meeting</label>\n' +
        '    <input type="text" id="finishReason" class="form-control mt-5" placeholder="Reasoning for ending meeting">\n' +
        '    <div class="mt-30 d-flex align-items-center justify-content-center">\n' +
        '        <button type="button" id="finishReserve" data-href="' + action + '" class="btn btn-sm btn-primary">' + finishReserveConfirm + '</button>\n' +
        '        <button type="button" class="btn btn-sm btn-danger ml-10 close-swl">' + finishReserveCancel + '</button>\n' +
        '    </div>\n' +
        '</div>';
        Swal.fire({
            title: finishReserveTitle,
            html: html,
            icon: 'warning',
            showConfirmButton: false,
            showCancelButton: false,
            allowOutsideClick: () => !Swal.isLoading(),
        });
    });

    $('body').on('click', '#finishReserve', function (e) {
        e.preventDefault();
        var $this = $(this);
        const href = $this.attr('data-href');
        const reason = $('#finishReason').val().trim(); // Get the reason input value

        $this.addClass('loadingbar primary').prop('disabled', true);

        $.post(href, { reason: reason }, function (result) {
            if (result && result.code === 200) {
                Swal.fire({
                    title: finishReserveSuccess,
                    text: finishReserveSuccessHint + "\n" + result.message,
                    showConfirmButton: false,
                    icon: 'success',
                });
                setTimeout(() => {

                    if (typeof result.redirect_to !== "undefined" && result.redirect_to !== undefined && result.redirect_to !== null && result.redirect_to !== '') {
                        window.location.href = result.redirect_to;
                    } else {
                        window.location.reload();
                    }
                }, 1000);
            } else {
                Swal.fire({
                    title: finishReserveFail,
                    text: finishReserveFailHint,
                    icon: 'error',
                })
            }
        }).error(err => {
            Swal.fire({
                title: finishReserveFail,
                text: finishReserveFailHint,
                icon: 'error',
            })
        }).always(() => {
            $this.removeClass('loadingbar primary').prop('disabled', false);
        });
    })
    $('body').on('click', '.add-meeting-url', function (e) {
        e.preventDefault();
        const item_id = $(this).attr('data-item-id');
        const meeting_password = $('.js-meeting-password-' + item_id).val();
        const meeting_link = $('.js-meeting-link-' + item_id).val();


        const $modalHtml = $('#liveMeetingLinkModal');

        Swal.fire({
            html: '<div id="meetingLinkModal">' + $modalHtml.html() + '</div>',
            showCancelButton: false,
            showConfirmButton: false,
            customClass: {
                content: 'p-0 text-left',
            },
            width: '48rem',
            onOpen: () => {
                const editModal = $('#meetingLinkModal');

                editModal.find('input[name="item_id"]').val(item_id);
                editModal.find('input[name="password"]').val(meeting_password);
                editModal.find('input[name="link"]').val(meeting_link);
            }
        });
    });

    $('body').on('click', '.js-save-meeting-link', function (e) {
        e.preventDefault();

        const $this = $(this);
        const $form = $this.closest('form');
        const action = $form.attr('action');

        const data = $form.serializeObject();

        $this.addClass('loadingbar primary').prop('disabled', true);

        $.post(action, data, function (result) {
            if (result && result.code === 200) {
                Swal.fire({
                    icon: 'success',
                    html: '<h3 class="font-20 text-center text-dark-blue">' + linkSuccessAdd + '</h3>',
                    showConfirmButton: false,
                });

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        }).fail(err => {
            $this.removeClass('loadingbar primary').prop('disabled', false);
            var errors = err.responseJSON;

            if (errors && errors.errors) {
                Object.keys(errors.errors).forEach((key) => {
                    const error = errors.errors[key];
                    let element = $form.find('[name="' + key + '"]');
                    element.addClass('is-invalid');
                    element.parent().find('.invalid-feedback').text(error[0]);
                });
            }
        });
    });

    $('body').on('click', '.js-add-meeting-session', function (e) {
        e.preventDefault();
        const item_id = $(this).attr('data-item-id');
        const itemDate = $(this).attr('data-date');


        const $modalHtml = $('#meetingCreateSessionModal');

        Swal.fire({
            html: '<div id="meetingSessionModal">' + $modalHtml.html() + '</div>',
            showCancelButton: false,
            showConfirmButton: false,
            customClass: {
                content: 'p-0 text-left',
            },
            width: '42rem',
            onOpen: () => {
                const editModal = $('#meetingSessionModal');

                editModal.find('input[name="item_id"]').val(item_id);
                editModal.find('.js-meeting-date').text(itemDate);
                editModal.find('.js-create-meeting-session').removeClass('d-none');
                editModal.find('.js-create-meeting-session').attr('data-item-id', item_id);

                editModal.find('.js-join-to-session').addClass('d-none');

                editModal.find('.js-for-create-session-text').removeClass('d-none');
                editModal.find('.js-for-join-session-text').addClass('d-none');
            }
        });
    });

    $('body').on('click', '.js-create-meeting-session', function (e) {
        e.preventDefault();

        const $this = $(this);
        const item_id = $this.attr('data-item-id');
        const action = `/panel/meetings/${item_id}/add-session`;

        $this.addClass('loadingbar primary').prop('disabled', true);

        const successHtml = `<div class="">
                <h3 class="font-16 text-center text-dark-blue">${sessionSuccessAdd}</h3>
                <p class="mt-5 font-14 text-gray">${youCanJoinTheSessionNowLang}</p>
            </div>`;

        $.post(action, {}, function (result) {
            if (result && result.code === 200) {
                Swal.fire({
                    icon: 'success',
                    html: successHtml,
                    showConfirmButton: false,
                });

                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            }
        }).fail(err => {
            $this.removeClass('loadingbar primary').prop('disabled', false);
        });
    });


    $('body').on('click', '.js-accept-meeting-request', function (e) {
    e.preventDefault();

    const $this = $(this);
    const requestId = $this.attr('data-item-id');// Assuming the button has data-id attribute
    const action = `/panel/meetings/${requestId}/accept-request`; // Adjust to your API route

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to accept this meeting request?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, accept it!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            $this.addClass('loadingbar primary').prop('disabled', true);

            $.post(action, {}, function (response) {
                if (response && response.code === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Accepted!',
                        text: response.message || 'The meeting request has been accepted.',
                        showConfirmButton: false,
                    });

                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: response.message || 'Something went wrong. Please try again.',
                    });
                }
            }).fail((err) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!',
                    text: 'Server error occurred. Please try again.',
                });
            }).always(() => {
                $this.removeClass('loadingbar primary').prop('disabled', false);
            });
        }
    });
});

})(jQuery);
