(function() {

    var self = {
        is_submitted: false,
        is_custom_fields_validate_passed: false,
        fields: [
            { id: 'frm_title',  is_valid: false, error: 'وارد کردن عنوان الزامی است', input: $('#frm_title'),   parent: $('#frm_title').closest('.form-group'),   help_block: $('#frm_title').siblings('.help-block').first() },
            { id: 'category',   is_valid: false, error: LANG__CATERGORY_REQUIRED,  input: $('#category'),    parent: $('#category').closest('.form-group'),    help_block: $('#category').siblings('.help-block').first() },
        ]
    };

    var form = $("#submit-item-form");
    var form_parent = form.parent();
    var submit_button = $("#submit_item");


    /*
    * handles the functionality for submitting form
    */
    form.on('submit', function(e) {
        e.preventDefault();

        self.is_submitted = true;

        validateAllFields();

        if(isFormValid()) {

            addLoading();
            form[0].submit();

        } else {
            $.each(self.fields, function(index, field) {
                applyErrorStatus(field);
            });

            errorToast(LANG__FIX_ERRORS);
            scrollToElement('#submit-item-form');
        }
    });

    function validateAllFields() {
        validateTitle();
        validateCategory();
    }

    /*
    * Checks whether the form is valid or not
    */
    function isFormValid() {
        var is_valid = true;

        $.each(self.fields, function(index, field) {
            if( ! field.is_valid ) {
                is_valid = false;
                return false;
            }
        });

        return is_valid;
    }

    /*
    * Shows or hides error status for the given field based on the current condition of field
    */
    function applyErrorStatus(field) {
        if( ! field.is_valid ) {
            field.input.addClass('error');
            field.parent.addClass('has-error');
            field.help_block.addClass('form-error').html(field.error);
        } else {
            field.input.removeClass('error');
            field.parent.removeClass('has-error');
            field.help_block.removeClass('form-error').html('');
        }
    }

    /*
    * flags the given field as invalid
    */
    function makeInvalid(field, error) {
        field.is_valid = false;
        field.error = error;
        if(self.is_submitted) {
            applyErrorStatus(field);
        }
    }

    /*
    * flags the given field as valid
    */
    function makeValid(field) {
        field.is_valid = true;
        field.error = null;
        if(self.is_submitted) {
            applyErrorStatus(field);
        }
    }

    /*
    * finds and returns the field with the given id from self.fields
    */
    function findField(field_id) {

        var field_index = null;

        $.each(self.fields, function(index, field) {
            if(field.id == field_id) {
                field_index = index;
                return false;
            }
        });

        return self.fields[field_index];
    }

    /*
    * Redirects to the given url
    */
    function redirect(url) {
        window.location = url;
    }

    /*
    * adds the loading to page and elements
    */
    function addLoading(text) {
        text = text || LANG__SENDING_DATA;
        submit_button.attr('disabled', 'disabled');
        //addPageLoading();
        submit_button.html(text + ' ... <i class="fa fa-spinner fa-spin top2"></i>');
    }

    /*
    * removes loading from page and elements
    */
    function removeLoading(button_text) {
        button_text = button_text || LANG__SUBMIT;
        submit_button.html(button_text);
        submit_button.removeAttr('disabled');
        //removePageLoading();
    }

    /*---------------------------------------------------------------
    *                    Validate Fields
    -----------------------------------------------------------------*/
    /*
    * Validates ads title on keyup
    */
    function validateTitle() {
        var field = findField('frm_title');
        var value = field.input.val();
        applyTitleValidation(field, value)

        field.input.on('input', function() {
            applyTitleValidation(field, $(this).val());
        });
    }
    function applyTitleValidation(field, value) {
        if( value == '' || value == ' ') {
            makeInvalid(field, 'وارد کردن عنوان الزامی است');
        } else {
            makeValid(field);
        }
    }

    /*
    * Validates category select box on change
    */
    function validateCategory() {
        var field = findField('category');
        var value = field.input.val();

        applyCategoryValidation(field, value);

        field.input.on('change', function() {
            applyCategoryValidation(field, $(this).val())
        });
    }
    function applyCategoryValidation(field, value) {
        if ( ! value || value == '' || value == 0 || value == 'any' ) {
            makeInvalid(field, LANG__CATERGORY_REQUIRED);
        } else {
            makeValid(field);
        }
    }

    function getCsrfToken() {
        return form.find("input[name='token']").val();
    }

})();