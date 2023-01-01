$('.will-expire').on('change', function () {
    var value = $(this).val();
    var target = $($(this).attr('data-target'));

    if (value == 0) {
        target.slideUp();
    } else {
        target.slideDown();
    }
});

$("#filter_category_id").on('change', function () {
    redirectTo(createRedirectUrl());
});
$("#filter_subcategory_id").on('change', function () {
    redirectTo(createRedirectUrl());
});
$("#filter_subsidiary_id").on('change', function () {
    redirectTo(createRedirectUrl());
});
$("#reset-filter").on('click', function () {
    redirectTo(GLOBE__filter_root);
});

function createRedirectUrl() {
    var category_id = $("#filter_category_id").val() || 0;
    var subcategory_id = $("#filter_subcategory_id").val() || 0;
    var subsidiary_id = $("#filter_subsidiary_id").val() || 0;

    return GLOBE__filter_root + "?filter_category_id=" + category_id + "&filter_subcategory_id=" + subcategory_id + "&filter_subsidiary_id=" + subsidiary_id;
}