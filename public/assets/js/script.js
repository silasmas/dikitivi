/**
 * Custom script
 * 
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */

var currentLanguage = $('html').attr('lang');
var currentHost = $('[name="dktv-url"]').attr('content');
// Modals
var modalUser = $('#cropModalUser');
// Preview images
var retrievedAvatar = document.getElementById('retrieved_image');
var retrievedMediaCover = document.getElementById('retrieved_media_cover');
var currentMediaCover = document.querySelector('#mediaCoverWrapper img');
var retrievedImageRecto = document.getElementById('retrieved_image_recto');
var currentImageRecto = document.querySelector('#rectoImageWrapper img');
var retrievedImageVerso = document.getElementById('retrieved_image_verso');
var currentImageVerso = document.querySelector('#versoImageWrapper img');
var cropper;

$(function () {
    $('.navbar, .card, .btn').addClass('shadow-0');
    $('.btn').css({ textTransform: 'inherit', paddingBottom: '0.5rem' });
    $('.back-to-top').click(function (e) {
        $("html, body").animate({ scrollTop: "0" });
    });

    /* Auto-resize textarea */
    autosize($('textarea'));

    // jQuery DataTable
    $('#dataList').DataTable({
        language: {
            url: currentHost + '/assets/addons/custom/dataTables/Plugins/i18n/' + $('html').attr('lang') + '.json'
        },
        paging: 'matchMedia' in window ? (window.matchMedia('(min-width: 500px)').matches ? true : false) : false,
        ordering: false,
        info: 'matchMedia' in window ? (window.matchMedia('(min-width: 500px)').matches ? true : false) : false,
    });

    /* jQuery Date picker */
    $('#register_birthdate').datepicker({
        dateFormat: currentLanguage.startsWith('fr') ? 'dd/mm/yy' : 'mm/dd/yy',
        onSelect: function () {
            $(this).focus();
        }
    });

    /* On select change, update de country phone code */
    $('#select_country1').on('change', function () {
        var countryPhoneCode = $(this).val();

        $('#phone_code_text1 .text-value').text(countryPhoneCode);
        $('#phone_code1').val(countryPhoneCode);
    });
    $('#select_country2').on('change', function () {
        var countryPhoneCode = $(this).val();

        $('#phone_code_text2 .text-value').text(countryPhoneCode);
        $('#phone_code2').val(countryPhoneCode);
    });
    $('#select_country3').on('change', function () {
        var countryPhoneCode = $(this).val();

        $('#phone_code_text3 .text-value').text(countryPhoneCode);
        $('#phone_code3').val(countryPhoneCode);
    });

    /* On check, show/hide some blocs */
    // OFFER TYPE
    $('#donationType .form-check-input').each(function () {
        $(this).on('click', function () {
            if ($('#anonyme').is(':checked')) {
                $('#donorIdentity, #otherDonation').addClass('d-none');

            } else {
                $('#donorIdentity, #otherDonation').removeClass('d-none');
            }
        });
    });
    // TRANSACTION TYPE
    $('#paymentMethod .form-check-input').each(function () {
        $(this).on('click', function () {
            if ($('#bank_card').is(':checked')) {
                $('#phoneNumberForMoney').addClass('d-none');

            } else {
                $('#phoneNumberForMoney').removeClass('d-none');
            }
        });
    });

    // AVATAR
    $('#avatar').on('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            retrievedAvatar.src = url;
            var modal = new bootstrap.Modal(document.getElementById('cropModalUser'), { keyboard: false });

            modal.show();
        };

        if (files && files.length > 0) {
            var reader = new FileReader();

            reader.onload = function () {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $(modalUser).on('shown.bs.modal', function () {
        cropper = new Cropper(retrievedAvatar, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '#cropModalUser .preview',
            done: function (data) { console.log(data); },
            error: function (data) { console.log(data); }
        });

    }).on('hidden.bs.modal', function () {
        cropper.destroy();

        cropper = null;
    });

    $('#cropModalUser #crop_avatar').click(function () {
        // Ajax loading image to tell user to wait
        $('.user-image').attr('src', currentHost + '/assets/img/ajax-loading.gif');

        var canvas = cropper.getCroppedCanvas({
            width: 700,
            height: 700
        });

        canvas.toBlob(function (blob) {
            URL.createObjectURL(blob);

            var reader = new FileReader();

            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64_data = reader.result;
                var entity_id = document.getElementById('user_id').value;
                var mUrl = apiURL + '/api/user/update_avatar_picture/' + parseInt($('#userId').val());
                var datas = JSON.stringify({ 'id': parseInt($('#userId').val()), 'user_id': entity_id, 'image_64': base64_data });

                $.ajax({
                    headers: headers,
                    type: 'PUT',
                    contentType: 'application/json',
                    url: mUrl,
                    dataType: 'json',
                    data: datas,
                    success: function (res) {
                        $('.user-image').attr('src', res);
                        window.location.reload();
                    },
                    error: function (xhr, error, status_description) {
                        console.log(xhr.responseJSON);
                        console.log(xhr.status);
                        console.log(error);
                        console.log(status_description);
                    }
                });
            };
        });
    });

    // RECTO
    $('#image_recto').on('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            retrievedImageRecto.src = url;
            var modal = new bootstrap.Modal(document.getElementById('cropModal_recto'), { keyboard: false });

            modal.show();
        };

        if (files && files.length > 0) {
            var reader = new FileReader();

            reader.onload = function () {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $('#cropModal_recto').on('shown.bs.modal', function () {
        cropper = new Cropper(retrievedImageRecto, {
            // aspectRatio: 4 / 3,
            viewMode: 3,
            preview: '#cropModal_recto .preview'
        });

    }).on('hidden.bs.modal', function () {
        cropper.destroy();

        cropper = null;
    });

    $('#cropModal_recto #crop_recto').on('click', function () {
        var canvas = cropper.getCroppedCanvas({
            width: 1280,
            height: 827
        });

        canvas.toBlob(function (blob) {
            URL.createObjectURL(blob);
            var reader = new FileReader();

            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64_data = reader.result;

                $(currentImageRecto).attr('src', base64_data);
                $('#data_recto').attr('value', base64_data);
            };
        });
    });

    // VERSO
    $('#image_verso').on('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            retrievedImageVerso.src = url;
            var modal = new bootstrap.Modal(document.getElementById('cropModal_verso'), { keyboard: false });

            modal.show();
        };

        if (files && files.length > 0) {
            var reader = new FileReader();

            reader.onload = function () {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $('#cropModal_verso').on('shown.bs.modal', function () {
        cropper = new Cropper(retrievedImageVerso, {
            // aspectRatio: 4 / 3,
            viewMode: 3,
            preview: '#cropModal_verso .preview'
        });

    }).on('hidden.bs.modal', function () {
        cropper.destroy();

        cropper = null;
    });

    $('#cropModal_verso #crop_verso').on('click', function () {
        var canvas = cropper.getCroppedCanvas({
            width: 1280,
            height: 827
        });

        canvas.toBlob(function (blob) {
            URL.createObjectURL(blob);
            var reader = new FileReader();

            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64_data = reader.result;

                $(currentImageVerso).attr('src', base64_data);
                $('#data_verso').attr('value', base64_data);
            };
        });
    });

    // MEDIA COVER
    $('#media_cover').on('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            retrievedImageNews.src = url;
            var modal = new bootstrap.Modal(document.getElementById('cropModal_media_cover'), { keyboard: false });

            modal.show();
        };

        if (files && files.length > 0) {
            var reader = new FileReader();

            reader.onload = function () {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $('#cropModal_media_cover').on('shown.bs.modal', function () {
        cropper = new Cropper(retrievedMediaCover, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '#cropModal_media_cover .preview'
        });

    }).on('hidden.bs.modal', function () {
        cropper.destroy();

        cropper = null;
    });

    $('#cropModal_media_cover #crop_media_cover').on('click', function () {
        var canvas = cropper.getCroppedCanvas({
            width: 700,
            height: 700
        });

        canvas.toBlob(function (blob) {
            URL.createObjectURL(blob);
            var reader = new FileReader();

            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64_data = reader.result;

                $(currentMediaCover).attr('src', base64_data);
                $('#media_cover_picture').attr('value', base64_data);
            };
        });
    });
});
