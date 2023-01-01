/**
 * Redirects user to the given url
 *
 * @param url
 */
function redirectTo(url) {
    document.location.href = url;
}

/**
 * Checks whether the given string is an email or not
 *
 * @param  value
 * @return Boolean
 */
function isEmail(value) {
    var email_pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

    return email_pattern.test(value);
}

/**
 * Check if source of map is GoogleMaps or not
 *
 * @return boolean
 */
function isGoogleMaps() {
    return (GLOBE__maps_source === 'GOOGLE');
}

/**
 * Check if source of map is CedarMaps or not
 *
 * @return boolean
 */
function isCedarMaps() {
    return (GLOBE__maps_source === 'CEDAR');
}

/**
 * Check if map is presented by leafletJs or not
 *
 * @return boolean
 */
function isLeafletMaps() {
    return (GLOBE__maps_source !== 'GOOGLE');
}

function showInput(a, b, c) {
    $(a).slideDown(), $(b).html(c).selectpicker("refresh");
}

function removeInput(a, b) {
    b = b || "", "" != b && $(b).html("<option value='any'>همه</option>").selectpicker("refresh"),
        $(a).slideUp();
}

/**
 * Removes the price input with the given name
 *
 * @param name
 */
function price_field_remover(name) {
    $('#' + name + '-type').change(function () {
        var type = $(this).val();
        var price_wrapper = $('#' + name + '-wrapper');

        if (type !== 'price') {
            price_wrapper.slideUp();
        } else {
            price_wrapper.slideDown();
        }
    })
}

/**
 * Blocks the element with given selector
 *
 * @param element_selector
 */
function blockElement(element_selector) {
    mApp.block(element_selector, {});
}

/**
 * unBlocks the element with given selector
 *
 * @param element_selector
 */
function unblockElement(element_selector) {
    mApp.unblock(element_selector);
}

/**
 * Blocks the whole page
 */
function blockScreen() {
    mApp.blockPage();
}

/**
 * unBlocks the whole page
 */
function unblockScreen() {
    mApp.unblockPage();
}

/**
 * strip html tags from the given text
 *
 * @param string
 * @returns string|boolean
 */
function stripTags(string) {
    if ((string === null) || (string === '')) {
        return false;
    }

    string = string.toString();
    return string.replace(/<[^>]*>/g, '');
}

/**
 * Replaces the given input with ckEditor instance
 * @param element_id
 */
function startCKEditor(element_id) {
    CKEDITOR.replace(element_id, {
        language: 'fa'
    });
}

/**
 * Initiates select2 instances
 */
function initiateSelect2() {
    $(".advanced-select").select2({
        dir: "rtl",
        language: "fa"
    });
}

/**
 * Initiates select2 instances for tags mode
 */
function initiateSelect2Tags() {
    $(".advanced-select-tags").select2({
        tags: true,
        dir: "rtl",
        language: "fa"
    }).on('select2:open', function (e) {
        $('.select2-container--open .select2-dropdown--below').css('display', 'none');
    });

    $(".select2-selection--multiple .select2-search__field").on('focus', function () {
        $(this).closest('.select-group--float').addClass('form-group--focused');
    }).on('blur', function () {
        $(this).closest('.select-group--float').removeClass('form-group--focused');
    });
}

/**
 * Shows an error toast
 *
 * @param message
 */
function errorToast(message) {
    toastr.options = {
        progressBar: !0,
        positionClass: "toast-top-left",
        preventDuplicates: !1,
        showDuration: "300",
        hideDuration: "300",
        timeOut: "3000",
        rtl: !0
    };
    toastr.error(message);
}

/**
 * Shows a success toast
 *
 * @param message
 */
function successToast(message) {
    toastr.options = {
        progressBar: !0,
        positionClass: "toast-top-left",
        preventDuplicates: !1,
        showDuration: "300",
        hideDuration: "300",
        timeOut: "3000",
        rtl: !0
    };
    toastr.success(message);
}

/**
 * Shows a info toast
 *
 * @param message
 */
function infoToast(message) {
    toastr.options = {
        progressBar: !0,
        positionClass: "toast-top-left",
        preventDuplicates: !1,
        showDuration: "300",
        hideDuration: "300",
        timeOut: "3000",
        rtl: !0
    };
    toastr.info(message);
}

/**
 * Clears all toast instances
 */
function clearToasts() {
    toastr.clear();
}

function addButtonLoading(element) {
    element.find('.loading').html('&nbsp;&nbsp; <i class="fa fa-spinner fa-spin"></i> ');
}
function removeButtonLoading(element) {
    element.find('.loading').html("");
}

/**
 * Scrolls to the requested element
 *
 * @param element
 */
function scrollToElement(element) {
    $("html, body").animate({
        scrollTop: $(element).offset().top
    }, 500);
}

/**
 * Starts a color picker on given element_id
 *
 * @param element_selector
 */
function startColorPicker(element_selector) {
    $(element_selector).colorpicker({
        format: 'auto'
    });
}

/**
 * Initiate all date picker fields
 */
function initiateDatePickers() {
    $(".date-picker").persianDatepicker({
        selectedBefore: !0,
        formatDate: "YYYY/0M/0D",
    });
}

/**
 * Converts Persian digits to english
 *
 * @param digit
 * @returns {string}
 */
function persianToEnglishDigits(digit) {
    if (!(-1 !== $.inArray(digit, [46, 8, 9, 27, 13, 190]) || 65 == digit && a.ctrlKey === !0 || digit >= 35 && 39 >= digit)) {
        digit = digit.toString();
        for (var c = "", d = 0; d < digit.length; d++) {
            var e = digit.charCodeAt(d), f = null;
            e >= 1776 && 1785 >= e ? (f = e - 1728, c += String.fromCharCode(f)) : e >= 1632 && 1641 >= e ? (f = e - 1584,
                c += String.fromCharCode(f)) : c += String.fromCharCode(e);
        }
        return c;
    }
}

/**
 * Show confirm modal for deleting an item
 */
$('*[data-confirm-delete]').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);

    swal({
        title: 'آیا از انجام عملیات حذف مطمئن هستید؟',
        text: "این عملیات غیرقابل بازگشت است",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن',
        cancelButtonText: 'انصراف'
    }).then(function (result) {
        if (result.value) {
            form[0].submit();
        }
    });
});


/**
 * Show confirm modal for deleting an item
 */
$('*[data-confirm-show]').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);
    var title = form.attr('data-title') || 'آیا از انجام این عملیات  مطمئن هستید؟';
    var text = form.attr('data-subtitle') || 'این عملیات غیرقابل بازگشت است';
    var type = form.attr('data-type') || 'warning';

    swal({
        title: title,
        text: text,
        type: type,
        showCancelButton: true,
        confirmButtonText: 'بله',
        cancelButtonText: 'انصراف'
    }).then(function (result) {
        if (result.value) {
            form[0].submit();
        }
    });
});

/**
 * Show confirm modal for deleting an item
 */
$('*[data-confirm-show--link]').on('click', function (e) {
    e.preventDefault();
    var $this = $(this);
    var title = $this.attr('data-title') || 'آیا از انجام این عملیات  مطمئن هستید؟';
    var text = $this.attr('data-subtitle') || 'این عملیات غیرقابل بازگشت است';
    var type = $this.attr('data-type') || 'warning';
    var link = $this.attr('data-link') || $this.attr('href');

    swal({
        title: title,
        text: text,
        type: type,
        showCancelButton: true,
        confirmButtonText: 'بله',
        cancelButtonText: 'انصراف'
    }).then(function (result) {
        if (result.value) {
            redirectTo(link)
        }
    });
});

/**
 * Show confirm modal for deleting an item
 */
$('.nav-menu-form *[data-click-to-submit]').on('click', function (e) {
    e.preventDefault();

    var form = $(this).closest('form');
    var action = $(this).attr('data-action');
    var action_name = $(this).find('.m-nav__link-text').first().text();
    var irreversible = $(this).attr('data-irreversible');


    form.find("input[name='selected_values[]']").remove();

    var checked = $("input.to-be-checked").map(function () {
        if ($(this).is(':checked')) {
            form.prepend($('<input/>').attr({type: 'hidden', name: 'selected_values[]', value: $(this).val()}));
            return $(this).val();
        }
    }).get();

    if (checked.length > 0) {
        swal({
            title: ' آیا از انجام عملیات ' + action_name + ' مطمئن هستید؟ ',
            text: (irreversible) ? "این عملیات غیرقابل بازگشت است" : null,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'بله',
            cancelButtonText: 'انصراف'
        }).then(function (result) {
            if (result.value) {
                form.find("input[name='action']").val(action);
                form.submit();
            }
        });

    } else {
        alert('هیچ آیتمی برای انجام عملیات انتخاب نشده است');
    }
});

/**
 * data tables checkbox for check or uncheck all rows
 */
$("*[data-click-checks-all-rows]").on('click', function (e) {
    if ($(this).is(':checked')) {
        $('.to-be-checked').prop('checked', true);
    } else {
        $('.to-be-checked').prop('checked', false);
    }
});

/**
 * adds proper class to float-input when input is focused
 */
$('body').on('focus', '.form-group--float .form-control', function () {
    $(this).parent().addClass('form-group--focused');
});

/**
 * adds proper class to float-input when input lost focused
 */
$('body').on('blur', '.form-group--float .form-control', function () {
    var $this = $(this);
    var value = $this.val();
    var form_control = $this.parent();

    form_control.removeClass('form-group--focused');

    if (value) {
        form_control.addClass('form-group--active');
    } else {
        form_control.removeClass('form-group--active');
    }
});

/**
 * Handles checkbox clicking for an input with checkbox
 */
$('*[data-text-with-checkbox]').on('change', function () {
    var target_input = $($(this).attr('data-input'));
    if ($(this).is(":checked")) {
        target_input.attr('readonly', 'readonly');
    } else {
        target_input.removeAttr('readonly');
    }
});

/**
 * Handles ajax calls on category select
 */
$("*[data-category-selector]").on('change', function () {
    var category_id = $(this).val();
    var target_element = $(this).attr('data-child-selector');

    $.ajax({
        url: 'process/ajax_calls.php',
        dataType: 'json',
        type: 'post',
        data: {
            action: 'parent-subcategories',
            category_id: category_id
        },
        success: function (response) {
            if (response.status) {
                $(target_element).html(response.html);
            }
        }
    });
});

/**
 * Restrict Input to only Digits
 */
$("body").on("keydown", "input.digits", function (input_text) {
    var value = persianToEnglishDigits(input_text.keyCode);
    -1 !== $.inArray(value, [46, 8, 9, 27, 13, 190]) || 65 == value && input_text.ctrlKey === !0 || value >= 35 && 39 >= value || (input_text.shiftKey || 48 > value || value > 57) && (96 > value || value > 105) && input_text.preventDefault();
});

/**
 * money formats the input
 */
$("body").on("keyup", "input.divide-price", function () {
    var value = persianToEnglishDigits(this.value);
    value = value.replace(/[^\d]/g, "");
    value.length > 3 && (value = value.replace(/\B(?=(?:\d{3})+(?!\d))/g, ","));
    this.value = value;
});


function startImagePreview(selector) {
    var wrapper = $(selector);

    var width = wrapper.attr('data-width');
    var height = wrapper.attr('data-height');
    var max_width = wrapper.attr('data-max-width') || 800;
    var max_height = wrapper.attr('data-max-height') || 600;
    var  default_image = wrapper.attr('data-default-image');

    if (default_image) {
        changeImageForImagePreview(default_image, wrapper, max_width, max_height);
    }

    if (width) {
        wrapper.css("width", width);
    }
    if (height) {
        wrapper.find('.imagePreview').css("height", height);
    }

    wrapper.on("change", "input[type='file']", function () {
        var thisFile = this;
        var files = !!thisFile.files ? thisFile.files : [];

        if (!files.length || !window.FileReader) {
            return false;
        }

        if (/^image/.test(files[0].type)) {
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);

            reader.onloadend = function () {
                changeImageForImagePreview(this.result, wrapper, max_width, max_height);
            }
        }
    });
}

function changeImageForImagePreview(main_image, wrapper, max_width, max_height) {
    var image = new Image();
    image.src = main_image;

    image.onload = function () {
        var new_height = (this.height <= 120) ? 120 : this.height;
        var new_width = (this.width <= 120) ? 120 : this.width;

        if (max_width && new_width > max_width) {
            new_width = max_width
        }
        if (max_height && new_height > max_height) {
            new_height = max_height;
        }

        wrapper.css("width", new_width);
        wrapper.find('.imagePreview').css("height", new_height).css("background-image", "url(" + main_image + ")");
    };
}

/**
 * Initiates Line chart on the given element_id
 *
 * @param element_id
 * @param label_text
 * @param labels_array
 * @param data_array
 * @param color
 */
function initiateLineChart(element_id, label_text, labels_array, data_array, color) {
    color = color || 'success';
    var background_color = (color === 'success') ? '#d1f1ec' : '#ffefce';
    var ctx = document.getElementById(element_id).getContext("2d");

    var gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, Chart.helpers.color(background_color).alpha(1).rgbString());
    gradient.addColorStop(1, Chart.helpers.color(background_color).alpha(0.3).rgbString());

    var config = {
        type: 'line',
        data: {
            labels: labels_array,
            datasets: [{
                label: label_text,
                backgroundColor: gradient,
                borderColor: mApp.getColor(color),

                pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                pointHoverBackgroundColor: mApp.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),

                //fill: 'start',
                data: data_array
            }]
        },
        options: {
            title: {
                display: false,
            },
            tooltips: {
                mode: 'nearest',
                intersect: false,
                position: 'nearest',
                xPadding: 10,
                yPadding: 10,
                caretPadding: 10
            },
            legend: {
                display: false,
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: false,
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: false,
                    gridLines: false,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            elements: {
                line: {
                    tension: 0.0000001
                },
                point: {
                    radius: 4,
                    borderWidth: 12
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 10,
                    bottom: 0
                }
            }
        }
    };

    var chart = new Chart(ctx, config);
}


/**
 * Initiates Curved chart on the given element_id
 *
 * @param element_id
 * @param label_text
 * @param labels_array
 * @param data_array
 * @param color
 */
function initiateCurveChart(element_id, label_text, labels_array, data_array, color) {
    color = color || 'success';

    var config = {
        type: 'line',
        data: {
            labels: labels_array,
            datasets: [{
                label: label_text,
                borderColor: mApp.getColor(color),
                borderWidth: 2,
                pointBackgroundColor: mApp.getColor(color),

                backgroundColor: mApp.getColor('accent'),

                pointHoverBackgroundColor: mApp.getColor('danger'),
                pointHoverBorderColor: Chart.helpers.color(mApp.getColor('danger')).alpha(0.2).rgbString(),
                data: data_array
            }]
        },
        options: {
            title: {
                display: false,
            },
            tooltips: {
                intersect: false,
                mode: 'nearest',
                xPadding: 10,
                yPadding: 10,
                caretPadding: 10
            },
            legend: {
                display: false,
                labels: {
                    usePointStyle: false
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            hover: {
                mode: 'index'
            },
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: false,
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: false,
                    gridLines: false,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            },

            elements: {
                point: {
                    radius: 3,
                    borderWidth: 0,

                    hoverRadius: 8,
                    hoverBorderWidth: 2
                }
            }
        }
    };

    var chart = new Chart($(element_id), config);
}

function confirmDeleteModal(confirmCallback) {
    swal({
        title: 'آیا از انجام عملیات حذف مطمئن هستید؟',
        text: "این عملیات غیرقابل بازگشت است",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن',
        cancelButtonText: 'انصراف'
    }).then(function (result) {
        if (result.value) {
            confirmCallback();
        }
    });
}

function priceFormat(value, show_currency, currency) {
    show_currency = show_currency || true;
    currency = currency || ' تومان';
    var formatted =  value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    if (show_currency) {
        return formatted + ' ' + currency;
    }

    return formatted;
}

function refreshSelectPicker() {
    $('.selectpicker').selectpicker('refresh');
}
