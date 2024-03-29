/**
 * Custom script
 * 
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
// Common variables
var currentLanguage = $('html').attr('lang');
var currentUser = $('[name="dktv-visitor"]').attr('content');
var currentHost = $('[name="dktv-url"]').attr('content');
var apiHost = $('[name="dktv-api-url"]').attr('content');
var headers = { 'Authorization': 'Bearer ' + $('[name="dktv-ref"]').attr('content'), 'Accept': $('.mime-type').val(), 'X-localization': navigator.language };
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
// Toggle app theme
const MDB_LIGHT = currentHost + '/assets/addons/custom/mdb/css/mdb.min.css';
const MDB_DARK = currentHost + '/assets/addons/custom/mdb/css/mdb.dark.min.css';

/**
 * Set theme to light
 */
function themeLight() {
    $('p, span, small, .list-group-item, .card-header, .card-body, .card-body h4, .dropdown-menu, .dropdown-menu *').addClass('text-dark').removeClass('text-white');
    $('.fotter-socail li a, .footer-list li a').removeClass('text-light');
    $('#mdb-style').attr('href', MDB_LIGHT);

    document.cookie = "theme=light";
}

/**
 * Set theme to dark
 */
function themeDark() {
    $('p, span, small, .list-group-item, .card-header, .card-body, .card-body h4, .dropdown-menu, .dropdown-menu *').addClass('text-white').removeClass('text-dark');
    $('.fotter-socail li a, .footer-list li a').addClass('text-light');
    $('#mdb-style').attr('href', MDB_DARK);

    document.cookie = "theme=dark";
}

/**
 * Set theme to auto
 */
function themeAuto() {
    const darkThemeMq = window.matchMedia("(prefers-color-scheme: dark)");

    if (darkThemeMq.matches) {
        $('p, span, small, .list-group-item, .card-header, .card-body, .card-body h4, .dropdown-menu, .dropdown-menu *').addClass('text-white').removeClass('text-dark');
        $('.fotter-socail li a, .footer-list li a').addClass('text-white');
        $('#mdb-style').attr('href', MDB_DARK);

    } else {
        $('p, span, small, .list-group-item, .card-header, .card-body, .card-body h4, .dropdown-menu, .dropdown-menu *').addClass('text-dark').removeClass('text-white');
        $('.fotter-socail li a, .footer-list li a').removeClass('text-white');
        $('#mdb-style').attr('href', MDB_LIGHT);
    }

    document.cookie = "theme=auto";
}

/**
 * Check string is numeric
 * 
 * @param string str 
 */
function isNumeric(str) {
    if (typeof str != "string") {
        return false
    } // we only process strings!

    return !isNaN(str) && // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
        !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
}

/**
 * Get cookie by name
 * 
 * @param string cname 
 */
function getCookie(cname) {
    let name = cname + '=';
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');

    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];

        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }

    return '';
}

/**
 * Toggle Password Visibility
 * 
 * @param string current 
 * @param string element 
 */
function passwordVisible(current, element) {
    var el = document.getElementById(element);

    if (el.type === 'password') {
        el.type = 'text';
        current.innerHTML = '<i class="bi bi-eye-slash-fill"></i>'

    } else {
        el.type = 'password';
        current.innerHTML = '<i class="bi bi-eye-fill"></i>'
    }
}

/**
 * Switch between two elements visibility
 * 
 * @param string current
 * @param string element1
 * @param string element2
 * @param string message1
 * @param string message2
 */
function switchDisplay(current, form_id, element1, element2, message1, message2) {
    var _form = document.getElementById(form_id);
    var el1 = document.getElementById(element1);
    var el2 = document.getElementById(element2);

    _form.reset();
    el1.classList.toggle('d-none');
    el2.classList.toggle('d-none');

    if (el1.classList.contains('d-none')) {
        current.innerHTML = message1;
    }

    if (el2.classList.contains('d-none')) {
        current.innerHTML = message2;
    }
}

/**
 * Token writter
 * 
 * @param string id
 */
function tokenWritter(id) {
    var _val = document.getElementById(id).value;
    var _splitId = id.split('_');
    var key = event.keyCode || event.charCode;

    if (key === 8 || key === 46 || key === 37) {
        if (_splitId[2] !== '1') {
            var previousElement = document.getElementById('check_digit_' + (parseInt(_splitId[2]) - 1));

            previousElement.focus();
        }

    } else {
        var nextElement = document.getElementById('check_digit_' + (parseInt(_splitId[2]) + 1));

        if (key === 39) {
            nextElement.focus();
        }

        if (_splitId[2] !== '7') {
            if (_val !== undefined && Number.isInteger(parseInt(_val))) {
                nextElement.focus();
            }
        }
    }
}

/**
 * Dynamically load JS files
 */
function loadAllJS() {
    $.getScript('/assets/addons/custom/jquery/js/jquery.min.js');
    $.getScript('/assets/addons/custom/jquery/js/jquery-ui.min.js');
    $.getScript('/assets/addons/streamo/js/vendor/jquery-migrate-3.3.0.min.js');
    $.getScript('/assets/addons/custom/bootstrap/js/popper.min.js');
    $.getScript('/assets/addons/custom/mdb/js/mdb.min.js');
    $.getScript('/assets/addons/custom/bootstrap/js/bootstrap.bundle.min.js');
    $.getScript('/assets/addons/streamo/js/plugins.js');
    $.getScript('/assets/addons/streamo/js/ajax-mail.js');
    $.getScript('/assets/addons/custom/perfect-scrollbar/dist/perfect-scrollbar.min.js');
    $.getScript('/assets/addons/custom/cropper/js/cropper.min.js');
    $.getScript('/assets/addons/custom/sweetalert2/dist/sweetalert2.min.js');
    $.getScript('/assets/addons/custom/jquery/scroll4ever/js/jquery.scroll4ever.js');
    $.getScript('/assets/addons/custom/autosize/js/autosize.min.js');
    $.getScript('/assets/addons/streamo/js/main.js');
    $.getScript('/assets/addons/custom/biliap/js/biliap.cores.js');
    $.getScript('/assets/js/script.js');
}

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

    /* Perfect scrollbar */
    const ps = new PerfectScrollbar('.perfect-scrollbar', {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 20
    });

    /* Bootstrap Tooltip */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    /* jQuery scroll4ever */
    $('#scope').scroll4ever({
        trigger: '.next-page-link',
        container: '#items',
        selector: '.item',
        distance: 100,
        debug: true,
        start: function () { $('.next-page-link').html('<div class="loader"><div class="loaderBar"></div></div>'); },
        complete: function () { }
    });

    /* jQuery Date picker */
    $('#register_birthdate').datepicker({
        dateFormat: currentLanguage.startsWith('fr') || currentLanguage.startsWith('ln') ? 'dd/mm/yy' : 'mm/dd/yy',
        onSelect: function () {
            $(this).focus();
        }
    });

    /* On select change, update de country phone code */
    $('#select_country1').on('change', function () {
        var countryData = $(this).val();
        var countryDataArray = countryData.split('-');
        // Get ID and Phone code from splitted data
        var countryId = countryDataArray[1];
        var countryPhoneCode = countryDataArray[0];

        $('#phone_code_text1 .text-value').text(countryPhoneCode);
        $('#country_id1').val(countryId);
        $('#phone_code1').val(countryPhoneCode);
    });
    $('#select_country2').on('change', function () {
        var countryData = $(this).val();
        var countryDataArray = countryData.split('-');
        // Get ID and Phone code from splitted data
        var countryId = countryDataArray[1];
        var countryPhoneCode = countryDataArray[0];

        $('#phone_code_text2 .text-value').text(countryPhoneCode);
        $('#country_id2').val(countryId);
        $('#phone_code2').val(countryPhoneCode);
    });
    $('#select_country3').on('change', function () {
        var countryData = $(this).val();
        var countryDataArray = countryData.split('-');
        // Get ID and Phone code from splitted data
        var countryId = countryDataArray[1];
        var countryPhoneCode = countryDataArray[0];

        $('#phone_code_text3 .text-value').text(countryPhoneCode);
        $('#country_id3').val(countryId);
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
                var mUrl = apiURL + '/api/user/update_avatar_picture/' + parseInt(currentUser);
                var datas = JSON.stringify({ 'id': parseInt(currentUser), 'user_id': currentUser, 'image_64': base64_data });

                $.ajax({
                    headers: headers,
                    type: 'PUT',
                    contentType: 'application/json',
                    url: mUrl,
                    dataType: 'json',
                    data: datas,
                    success: function (res) {
                        $('.user-image').attr('src', res);
                        location.reload(true);
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

    /* Register form-data */
    $('form#data').submit(function (e) {
        e.preventDefault();
        $('#data p').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

        var formData = new FormData(this);

        $.ajax({
            headers: headers,
            type: $('#data .form-method').val(),
            url: apiHost + $('#data .path-name').val(),
            data: formData,
            success: function (res) {
                $('#data p').addClass('text-success').html(res.message);
                location.reload();
            },
            cache: false,
            contentType: false,
            processData: false,
            error: function (xhr, error, status_description) {
                $('#data p').addClass('text-danger').html(xhr.responseJSON.message + ' : ' + xhr.responseJSON.error);
                console.log(xhr.responseJSON);
                console.log(xhr.status);
                console.log(error);
                console.log(status_description);
            }
        });
    });

    /* Theme management */
    // DEFAULT FACTS
    if (isNumeric(currentUser)) {
        $.ajax({
            headers: headers,
            type: 'GET',
            contentType: 'application/json',
            url: apiHost + '/user/' + parseInt(currentUser),
            success: function (result) {
                if (result.data.prefered_theme !== null) {
                    if (result.data.prefered_theme === 'dark') {
                        themeDark();

                    } else {
                        if (result.data.prefered_theme === 'light') {
                            themeLight();
                        } else {
                            themeAuto();
                        }
                    }

                } else {
                    themeAuto();
                }
            },
            error: function (xhr, error, status_description) {
                console.log(xhr.responseJSON);
                console.log(xhr.status);
                console.log(error);
                console.log(status_description);
            }
        });

    } else {
        if (getCookie('theme') === 'dark') {
            themeDark();

        } else {
            if (getCookie('theme') === 'light') {
                themeLight();
            } else {
                themeAuto();
            }
        }
    }
    // USER CHOOSES LIGHT
    $('#themeToggler .light').on('click', function (e) {
        e.preventDefault();
        $('#themeToggler .current-theme').html('<i class="bi bi-sun"></i>');

        // If user is connected, set is theme preference
        if (isNumeric(currentUser)) {
            $.ajax({
                headers: headers,
                type: 'PUT',
                contentType: 'application/json',
                url: apiHost + '/user/' + currentUser,
                data: JSON.stringify({ 'id': currentUser, 'prefered_theme': 'light' }),
                success: function () {
                    $(this).unbind('click');
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                },
                error: function (xhr, error, status_description) {
                    console.log(xhr.responseJSON);
                    console.log(xhr.status);
                    console.log(error);
                    console.log(status_description);
                }
            });

            // Otherwise, change is theme locally
        } else {
            themeLight();
        }
    });

    // USER CHOOSES DARK
    $('#themeToggler .dark').on('click', function (e) {
        e.preventDefault();
        $('#themeToggler .current-theme').html('<i class="bi bi-moon-fill"></i>');

        // If user is connected, set is theme preference
        if (isNumeric(currentUser)) {
            $.ajax({
                headers: headers,
                type: 'PUT',
                contentType: 'application/json',
                url: apiHost + '/user/' + currentUser,
                data: JSON.stringify({ 'id': currentUser, 'prefered_theme': 'dark' }),
                success: function () {
                    $(this).unbind('click');
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                },
                error: function (xhr, error, status_description) {
                    console.log(xhr.responseJSON);
                    console.log(xhr.status);
                    console.log(error);
                    console.log(status_description);
                }
            });

            // Otherwise, change is theme locally
        } else {
            themeDark();
        }
    });

    // USER CHOOSES AUTO
    $('#themeToggler .auto').on('click', function (e) {
        e.preventDefault();
        $('#themeToggler .current-theme').html('<i class="bi bi-circle-half"></i>');

        // If user is connected, set is theme preference
        if (isNumeric(currentUser)) {
            $.ajax({
                headers: headers,
                type: 'PUT',
                contentType: 'application/json',
                url: apiHost + '/user/' + currentUser,
                data: JSON.stringify({ 'id': currentUser, 'prefered_theme': 'auto' }),
                success: function () {
                    $(this).unbind('click');
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                },
                error: function (xhr, error, status_description) {
                    console.log(xhr.responseJSON);
                    console.log(xhr.status);
                    console.log(error);
                    console.log(status_description);
                }
            });

            // Otherwise, change is theme locally
        } else {
            themeAuto();
        }
    });
});
