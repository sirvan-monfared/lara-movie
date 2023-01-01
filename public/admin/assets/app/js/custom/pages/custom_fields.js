var portlet_id = "#main-fields-wrapper";
var category_selector = "#select-category";
var subcategory_selector = "#select-subcategory";
var subcategory_placeholder = "#subcategory-placeholder";
var subsidiary_selector = "#select-subsidiary";
var subsidiary_placeholder = "#subsidiary-placeholder";
var edit_button = $("#edit-custom-field-button");

$(category_selector).change(function () {
    var catId = $(this).val();

    blockElement(portlet_id);

    $.ajax({
        url: "process/ajax_calls.php",
        type: "POST",
        dataType: "JSON",
        data: {
            catId: catId,
            action: "find-subcategory-for-custom-fields-page"
        },
        success: function (data) {
            unblockElement(portlet_id);

            removeInput('#subcategory-placeholder', '#select-subcategory');
            removeInput('#subsidiary-placeholder', '#select-subsidiary');
            removeInput('#search-custom-fields');

            if (data.status === true) {
                showInput('#subcategory-placeholder', '#select-subcategory', data.result);

                edit_button.slideDown();
                changeEditLink(catId, 0);
            } else {
                edit_button.slideUp();
            }
        }
    })
});

$(subcategory_selector).change(function () {
    var catId = $("#select-category").val();
    var subcatId = $(this).val();

    blockElement(portlet_id);

    $.ajax({
        url: "process/ajax_calls.php",
        type: "POST",
        dataType: "JSON",
        data: {
            catId: catId,
            subcatId: subcatId,
            action: "find-subsidiary-for-custom-fields-page"
        },
        success: function (data) {

            unblockElement(portlet_id);

            removeInput('#subsidiary-placeholder', '#select-subsidiary');

            changeEditLink(catId, subcatId);
            edit_button.slideDown();

            if (data.status === true) {
                showInput('#subsidiary-placeholder', '#select-subsidiary', data.result);
            } else {

            }

        }
    })
});

$(subsidiary_selector).change(function () {
    var catId = $("#select-category").val();
    var subcatId = $("#select-subcategory").val();
    var subsidiaryId = $(this).val();

    blockScreen();

    $.ajax({
        url  : "process/ajax_calls.php",
        type : "POST",
        dataType : "JSON",
        data : {
            catId : catId,
            subcatId : subcatId,
            subsidiaryId : subsidiaryId,
            action : "find-final-result-for-custom-fields-page"
        },
        success : function(data)
        {
            unblockScreen();

            edit_button.slideDown();
            changeEditLink(catId, subsidiaryId);
        }
    });
});

function refreshSelectBox(selectObject) {
    return selectObject.select2({
        dir: "rtl",
        language: "fa"
    });
}

function changeEditLink(cat_id, subcat_id) {
    edit_button.find('a').attr('href', GLOBE__form_builder_url + '?cat_id=' + cat_id + '&subcat_id=' + subcat_id);
}