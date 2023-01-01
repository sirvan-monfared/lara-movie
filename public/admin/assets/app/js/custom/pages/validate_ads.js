(function() {

    var self = {
        is_submitted: false,
        is_custom_fields_validate_passed: false,
        fields: [
            { id: 'frm_title',         is_valid: false, error: LANG__TITLE_REQUIRED,            input: $('#frm_title'),                 parent: $('#frm_title').closest('.form-group'),                 help_block: $('#frm_title').siblings('.help-block').first() },
            { id: 'frm_plan_type',     is_valid: false, error: LANG__PLAN_REQUIRED,             input: $('#frm_plan_type'),             parent: $('#frm_plan_type').closest('.form-group'),             help_block: $('#frm_plan_type').siblings('.help-block').first() },
            { id: 'select-category',   is_valid: false, error: LANG__CATERGORY_REQUIRED,        input: $('#select-category'),           parent: $('#select-category').closest('.form-group'),           help_block: $('#category-help-block') },
            { id: 'select-subcategory',is_valid: false, error: LANG__CATERGORY_REQUIRED,        input: $('#select-subcategory'),        parent: $('#select-subcategory').closest('.form-group'),        help_block: $('#category-help-block') },
            { id: 'select-subsidiary', is_valid: false, error: LANG__CATERGORY_REQUIRED,        input: $('#select-subsidiary'),         parent: $('#select-subsidiary').closest('.form-group'),         help_block: $('#category-help-block') },
            { id: 'frm_states',        is_valid: false, error: LANG__STATE_REQUIRED,            input: $('#state_id'),                  parent: $('#state_id').closest('.form-group'),                  help_block: $('#state_id').siblings('.help-block').first() },
            { id: 'frm_cities',        is_valid: false, error: LANG__CITY_REQUIRED,             input: $('#city_id'),                   parent: $('#city_id').closest('.form-group'),                   help_block: $('#city_id').siblings('.help-block').first() },
            { id: 'frm_mail',          is_valid: false, error: 'آدرس ایمیل وارد شده معتبر نیست', input: $('#frm_mail'),                 parent: $('#frm_mail').closest('.form-group'),                  help_block: $('#frm_mail').siblings('.help-block').first() },
            { id: 'frm_discount',      is_valid: false, error: 'درصد تخفیف معتبر نیست',         input: $('#frm_discount'),              parent: $('#frm_discount').closest('.form-group'),              help_block: $('#frm_discount').siblings('.help-block').first() },
            { id: 'frm_user',          is_valid: false, error: 'درصد تخفیف معتبر نیست',         input: $('#frm_user'),                  parent: $('#frm_user').closest('.form-group'),                  help_block: $('#frm_user').closest('.form-group').siblings('.help-block').first() },
        ]
    };

    var form = $("#submit-item-form");
    var submit_button = $("#submit_item");
    var custom_fields_wrapper = $("#search-custom-fields");
    var map_wrapper = $("#map-place");

    /*
    * handles the functionality for submitting form
    */
    form.on('submit', function(e) {
        e.preventDefault();

        self.is_submitted = true;

        validateAllFields();
        validateCustomFields();


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

    $("#show_map").on('change', function() {
        var is_checked = $(this).is(':checked');
        if (is_checked) {
            map_wrapper.slideDown();
        } else {
            map_wrapper.slideUp();
        }
    });


    function validateAllFields() {
        validateTitle();
        validatePlanType();
        validateCategory();
        validateSubcategory();
        validateSubsidiary();
        validateState();
        validateCity();
        validateEmail();
        validateDiscount();
        validateUserField();
    }

    /*
    * Checks whether the form is valid or not
    */
    function isFormValid() {
        var is_valid = true;

        if( ! customFieldsValidatePassed() ) {
            is_valid = false;
        }

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
        applyTitleValidation(field, value);

        field.input.on('input', function() {
            applyTitleValidation(field, $(this).val());
        });
    }
    function applyTitleValidation(field, value) {
        if( value == '' || value == ' ') {
            makeInvalid(field, LANG__TITLE_REQUIRED);
        } else {
            makeValid(field);
        }
    }

    /*
    * Validates category selectbox on change
    */
    function validateCategory() {
        var field = findField('select-category');
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


    /*
    * Validate Subsidiary
    */
    function validateSubcategory() {
        var field        = findField('select-subcategory');
        var value        = field.input.val();
        var parent       = findField('select-category');

        applySubcategoryValidation(field, value, parent);

        field.input.on('change', function(e) {
            applySubcategoryValidation(field, $(this).val(), parent);
        })
    }
    /*
    * Validate Subsidiary
    */
    function validateSubsidiary() {
        var field        = findField('select-subsidiary');
        var value        = field.input.val();
        var parent       = findField('select-subcategory');

        applySubcategoryValidation(field, value, parent);

        field.input.on('change', function(e) {
            applySubcategoryValidation(field, $(this).val(), parent);
        })
    }
    function applySubcategoryValidation(field, value, parent) {
        if( ! parent.is_valid ) {
            return false;
        }

        var is_visible   = field.input.is(':visible');

        if( ! is_visible || ( is_visible && value && value != '' && value != ' ' && value != 0 && value != 'any' ) ) {
            makeValid(field);
        } else {
            makeInvalid(field, LANG__CATERGORY_REQUIRED);
        }
    }

    /**
     * Validates Ads type select
     */
    function validatePlanType() {
        var field = findField('frm_plan_type');
        var value = field.input.val();

        applySelectBoxValidation(field, value);

        field.input.on('change', function() {
            applySelectBoxValidation(field, $(this).val())
        });
    }

    /**
     * Validates User select
     */
    function validateUserField() {
        var field = findField('frm_user');
        var value = field.input.val();

        applySelectBoxValidation(field, value);

        field.input.on('change', function() {
            applySelectBoxValidation(field, $(this).val())
        });
    }


    /*
    * Validates State and City selectbox on change
    */
    function validateState() {
        var field = findField('frm_states');
        var value = field.input.val();

        applySelectBoxValidation(field, value);

        field.input.on('change', function() {
            applySelectBoxValidation(field, $(this).val())
        });
    }
    function validateCity() {
        var field = findField('frm_cities');
        var value = field.input.val();

        applySelectBoxValidation(field, value);

        field.input.on('change', function() {
            applySelectBoxValidation(field, $(this).val())
        });
    }
    function applySelectBoxValidation(field, value) {
        if ( ! value || value == '' || value == 0 || value == 'any' ) {
            makeInvalid(field, LANG__SELECT_VALUE);
        } else {
            makeValid(field);
        }
    }


    /*
    * Validates email on keyup
    */
    function validateEmail() {
        var field = findField('frm_mail');
        var value = field.input.val();

        applyEmailValidation(field, value)

        field.input.on('input', function() {
            applyEmailValidation(field, $(this).val());
        });
    }
    function applyEmailValidation(field, value) {
        if( value && value != '' && value != ' ' && ! isEmail(value)) {
            makeInvalid(field, 'آدرس ایمیل وارد شده معتبر نیست');
        } else {
            makeValid(field);
        }
    }


    /*
    * Validates email on keyup
    */
    function validateDiscount() {
        var field = findField('frm_discount');
        var value = field.input.val();

        applyDiscountValidation(field, value)

        field.input.on('input', function() {
            applyDiscountValidation(field, $(this).val());
        });
    }
    function applyDiscountValidation(field, value) {

        var is_visible = field.input.is(':visible');

        if( is_visible && value && value != '' && value != ' ' && ( value < 1 || value > 99) ) {
            makeInvalid(field, 'درصد تخفیف باید عددی بین 1 و 99 باشد');
        } else {
            makeValid(field);
        }
    }

/*---------------------------------------------------------------
*                    Validate Custom Fields
-----------------------------------------------------------------*/

    function customFieldsValidatePassed() {
        return self.is_custom_fields_validate_passed;
    }

    function validateCustomFields() {
        custom_fields_wrapper = $("#search-custom-fields");

        self.is_custom_fields_validate_passed = true;

        validatePriceCustomFields();
        validateRadioCustomFields();
        validateTextCustomFields();
        validateSelectCustomFields();
    }

    function validatePriceCustomFields() {
        var price_fields = custom_fields_wrapper.find('.custom-field__price');

        price_fields.each(function(index, input) {
            var $this = $(input);

            if( ! isCustomFieldRequired($this) ) {
                return false;
            }

            var name = $this.attr('data-name');
            var price_type_input = $this.find('#'+name+'-type');
            var price_input = $this.find('#'+name);
            var price_type = price_type_input.val();
            var price = price_input.val();

            if( price_type !== 'price' && price_type !== 'free' && price_type !== 'deal' && price_type !== 'exchange' ) {
                makeCustomFieldInvalid(price_type_input, LANG__INVALID_VALUE);
            } else {
                makeCustomFieldValid(price_type_input);
            }

            if( price_type === 'price' && ( ! price || price == '' || price == ' ' || price == 0) ) {
                makeCustomFieldInvalid(price_input);
            } else {
                makeCustomFieldValid(price_input);
            }
        });
    }

    function validateTextCustomFields() {
        var text_fields = custom_fields_wrapper.find('.custom-field__text');

        text_fields.each(function(index, input) {
            var $this = $(input);

            if( ! isCustomFieldRequired($this) ) {
                return false;
            }

            var name = $this.attr('data-name');
            var field = $this.find("input[name="+name+"]");
            if( field.val() == '' || field.val() == ' ' ) {
                makeCustomFieldInvalid(field);
            } else {
                makeCustomFieldValid(field);
            }
        });
    }

    function validateRadioCustomFields() {
        var radio_fields = custom_fields_wrapper.find('.custom-field__radio');

        radio_fields.each(function(index, input) {
            var $this = $(input);

            if( ! isCustomFieldRequired($this) ) {
                return false;
            }

            var name = $this.attr('data-name');
            if( ! $this.find("input[name="+name+"]:checked").val() ) {
                makeRadioFieldInvalid($this);
            } else {
                makeRadioFieldValid($this);
            }
        });
    }

    function validateSelectCustomFields() {
        var select_fields = custom_fields_wrapper.find('.custom-field__select');

        select_fields.each(function(index, input) {
            var $this = $(input);

            if( ! isCustomFieldRequired($this) ) {
                return false;
            }

            var name = $this.attr('data-name');
            var field = $this.find("select[name="+name+"]");

            if( ! field.val() || field.val() == '' || field.val() == 'any' ) {
                makeCustomFieldInvalid(field, LANG__SELECT_VALUE);
            } else {
                makeCustomFieldValid(field);
            }
        });
    }

    function isCustomFieldRequired(input) {
        return (input.attr('data-is-required') == 1);
    }

    function makeCustomFieldInvalid(input, error) {
        error = error || LANG__REQUIRED_FIELD;

        self.is_custom_fields_validate_passed = false;

        input.addClass('error');
        input.closest('.form-group').addClass('has-error');
        input.closest('.form-group').siblings('.help-block').first().addClass('form-error').html(error);
    }

    function makeRadioFieldInvalid(input) {
        self.is_custom_fields_validate_passed = false;

        input.find('.form-group').addClass('has-error');
        input.find('.help-block').addClass('form-error').html(LANG__SELECT_VALUE);
    }

    function makeCustomFieldValid(input) {
        input.removeClass('error');
        input.closest('.form-group').removeClass('has-error');
        input.closest('.form-group').siblings('.help-block').first().removeClass('form-error').html('');
    }

    function makeRadioFieldValid(input) {
        input.find('.form-group').removeClass('has-error');
        input.find('.help-block').removeClass('form-error').html('');
    }

    function getCsrfToken() {
        return form.find("input[name='token']").val();
    }

})();