$(function($) {
    var $fbTemplate = $(document.getElementById('fb-editor'));
    var options = {
        i18n: {
            locale: 'fa-IR'
        },
        onSave: function(e, formData) {
            var confirm_response = confirm("آیا مایل به ذخیره تغییرات هستید؟");
            if (confirm_response) {
                sendData(formData);
            }
        },
        disabledActionButtons: [
            'data'
        ],
        editOnAdd: false,
        stickyControls: {
            enable: true,
            offset: {
                top: 20
            }
        },
        disableFields: [
            'autocomplete',
            'button',
            'checkbox-group',
            'date',
            'file',
            'header',
            'hidden',
            'paragraph',
            'number',
            'textarea'
        ],
        disabledAttrs: [
            'access'
        ],
        typeUserDisabledAttrs: {
            'select': [
                'placeholder',
                'multiple'
            ],
            'radio-group': [
                'other',
                'inline',
                'required'
            ],
            'text': [
                'maxlength',
                'value',
                'subtype'
            ],
            'textarea': [
                'maxlength',
                'value',
                'subtype'
            ],
            'price': [
                'required',
                'placeholder',
                'className',
                'value'
            ],
            'link': [
                'maxlength',
                'value',
                'subtype'
            ]
        },
        fields : [
            {
                label: 'فیلد قیمت',
                attrs: {
                    type: 'price'
                }
            },
            {
                label: 'فیلد لینک',
                attrs: {
                    type: 'link'
                }
            }],
        controlOrder: [
            'price',
            'text',
            'textarea',
            'select-group',
            'radio-group'
        ],
        templates : {
            price: function(fieldData) {
                return {
                    field: '<span id="' + fieldData.name + '">',
                    onRender: function() {
                        //alert('yes');
                    }
                };
            },
            link: function(fieldData) {
                return {
                    field: '<span id="' + fieldData.name + '">',
                    onRender: function() {
                        //alert('yes');
                    }
                };
            }
        },

        formData: form_data
    };

    $fbTemplate.formBuilder(options);
});

/**
 * Handles sending data via ajax
 *
 * @param data
 */
function sendData(data) {
    $.ajax({
        url : '',
        dataType : 'json',
        type : 'post',
        data : {
            action: 'save-custom-fields',
            data: data
        },
        success : function(response){
            if (response.status) {
                successToast(response.html);
            } else {
                errorToast(response.errors);
            }
        }
    });
}