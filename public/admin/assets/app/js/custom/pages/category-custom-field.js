function refreshSelectBox(selectObject) {
    return selectObject.select2({
        dir: "rtl",
        language: "fa"
    });
}

var portlet_id = "#main-fields-wrapper";
var category_selector = "#select-category";
var subcategory_selector = "#select-subcategory";
var subcategory_placeholder = "#subcategory-placeholder";
var subsidiary_selector = "#select-subsidiary";
var subsidiary_placeholder = "#subsidiary-placeholder";
var category_ajax_url = (typeof GLOBE__category_ajax_url !== 'undefined') ? GLOBE__category_ajax_url : "../process/pr_ajax_calls.php";

$(category_selector).change(function() {
    var catId = $(this).val();
    var type = $(this).attr('data-type');
    var action = $(this).attr('data-action') || 'find-subcategory-for-search';

    blockElement(portlet_id);

    $.ajax({
        url  : category_ajax_url,
        type : "POST",
        dataType : "JSON",
        data : {
            catId  : catId,
            action : action,
            type   : type
        },
        success : function(data) {

            unblockElement(portlet_id);

            removeInput(subsidiary_placeholder, '#search-select-subsidiary');
            removeInput(subcategory_placeholder);
            removeInput('#search-custom-fields');

            if(data.status === true) {

                $(subcategory_placeholder).slideDown();
                refreshSelectBox($(subcategory_selector).html(data.result));

            } else {

                $("#select-placeholder").html("");
                refreshSelectBox($(subcategory_selector));
                $(subcategory_selector).val(0);
                $(subcategory_placeholder).hide();

                if(data.custom_field_status === true) {
                    $('.hide-when-custom-has-fields').slideUp();
                    $("#search-custom-fields").html(data.custom_field_result).slideDown();
                    refreshSelectBox($(".advanced-select"));
                } else {
                    $('.hide-when-custom-has-fields').slideDown();
                    $("#search-custom-fields").html("");
                }
            }
        }
    })
});

$(subcategory_selector).change(function() {
    subcatId = $(this).val();
    var action = $(this).attr('data-action') || 'find-subsidiary';

    blockElement(portlet_id);

    $.ajax({
        url  : category_ajax_url,
        type : "POST",
        dataType : "JSON",
        data : {
            subcatId : subcatId,
            action : action
        },
        success : function(data){

            unblockElement(portlet_id);

            removeInput(subsidiary_placeholder, '#search-select-subsidiary');
            removeInput('#search-custom-fields');

            if(data.status === true)
            {
                $(subsidiary_placeholder).slideDown();
                refreshSelectBox($(subsidiary_selector).html(data.result));

            } else {
                $(subsidiary_selector).html("");
                refreshSelectBox($(subsidiary_selector));
                $(subsidiary_selector).val(0);
                $(subsidiary_placeholder).hide();

                if(data.custom_field_status === true) {
                    $('.hide-when-custom-has-fields').slideUp();
                    $("#search-custom-fields").html(data.custom_field_result).slideDown();
                    refreshSelectBox($(".advanced-select"));
                } else {
                    $('.hide-when-custom-has-fields').slideDown();
                    $("#search-custom-fields").html("");
                }
            }
        }
    })
});

$(subsidiary_selector).change(function() {
    subsidiaryId = $(this).val();
    subcatId     = $(subcategory_selector).val();
    var action = $(this).attr('data-action') || 'find-custom-field-for-subsidiary';

    blockElement(portlet_id);

    $.ajax({
        url  : category_ajax_url,
        type : "POST",
        dataType : "JSON",
        data : {
            parentId: subcatId,
            subsidiaryId : subsidiaryId,
            action : action
        },
        success : function(data){

            unblockElement(portlet_id);

            removeInput('#search-custom-fields');

            if(data.custom_field_status === true) {
                $('.hide-when-custom-has-fields').slideUp();
                $("#search-custom-fields").html(data.custom_field_result).slideDown();
                refreshSelectBox($(".advanced-select"));
            } else {
                $('.hide-when-custom-has-fields').slideDown();
                $("#search-custom-fields").html("");
            }
        }
    })
});