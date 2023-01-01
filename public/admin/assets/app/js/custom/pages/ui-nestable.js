var nestable_wrapper = $("#nestable");
var nestable_input = $("#output");

var nestable = nestable_wrapper.nestable({
    maxDepth : 1
});

updateInput(nestable_input, nestable_wrapper);

nestable.on('change', function() {
    updateInput(nestable_input, nestable_wrapper);
});

function updateInput(nestable_input, nestable_wrapper) {
    nestable_input.val(window.JSON.stringify(nestable_wrapper.nestable('serialize')));
}