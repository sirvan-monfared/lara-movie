(function($, window) {
    $('.multiple_dynamic_fields__addon.add-field').on('click', function() {
        var $this = $(this);
        var parent_node = $($this.attr('data-parent'));
        var title = parent_node.find('label').html();
        var name = parent_node.find('input').attr('name');
        var icon = parent_node.find('.input-icon-addon i').first().attr('class');


        var html = $('#dynamic-field-template').clone().removeAttr('id');
        html.find('label').html(title);
        html.find('input').attr('name', name);
        html.find('.input-icon-addon i').first().attr('class', icon);
        html.removeClass('hidden');

        parent_node.append(html);
    });

    $('body').on('click', '.remove-field', function() {
        $(this).closest('.multiple_dynamic_fields').remove();
    });
})(jQuery, window);
