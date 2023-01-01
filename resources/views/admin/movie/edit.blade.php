@extends('admin.layouts.form', [
    'action' => route('movie.update', $movie),
    'method' => 'PATCH',
    'cancel' => route('movie.index')
])

@section('form-fields')
    @include('admin.movie._create_form')
@endsection

@section('form-sidebar')
    @include('admin.movie._create_sidebar')
@endsection

@section('scripts')
    <script src="{{ asset('admin/scripts/remote-select.js') }}"></script>
    <script>
        $('.select2-multiple').select2();
    </script>

    <script>
        $('body').on('click', '.control-button.add-field', function() {
            $("#inputs-part").append($("#dynamic-field-template").html())
        });
        $('body').on('click', '.control-button.remove-field', function() {
            $(this).parent().remove();
        });

        var typingTimer;
        var doneTypingInterval = 700;
        var param_val = null;

        // on keyup start the count down
        $('body').on('keyup', '.actor-finder .find-actor', function () {
            var $this = $(this);
            param_val = $this.val();
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                doneTyping(param_val, $this);
            }, doneTypingInterval);
        });

        //on keydown, clear the countdown
        $('body').on('keydown', '.actor-finder.find-actor', function () {
            clearTimeout(typingTimer);
        });

        $('body').on('click', '.result-item', function() {
            var $this = $(this);
            var result_set = $this.closest('.result_set').first();
            result_set.siblings("input[type='hidden']").first().val($this.data('item-id'));
            result_set.slideUp();
            result_set.siblings('.row').first().find('.find-actor').first().val($this.data('item-name'))
                        .siblings('.input-icon-addon').html("<img src='"+ $this.data('item-image') +"'>");
        })

        /**
         * Function to be called after user finished typing register_param
         *
         */
        function doneTyping(param_val, object) {

            var output = "";

            $.ajax({
                url : '/api/search/person',
                dataType : 'json',
                type : 'GET',
                data : {
                    keyword: param_val
                },

                success : function(response){

                    var result_set_wrapper = object.parent().parent().siblings('.result_set').first();
                    result_set_wrapper.html('');
                    result_set_wrapper.slideDown();
                    if (response.length > 0) {

                        $.each(response, function (index, item) {
                            output = "<div class='result-item clearfix' data-item-id='"+ item.id +"' data-item-name='"+ item.name +"' data-item-image='"+ item.featured_image.mini_path +"'>";

                            if (item.featured_image) {
                                output += "<div class='result-item__avatar'><img src='" + item.featured_image.mini_path + "' /></div>";
                                output += "<div class='result-item__meta'>";
                            }

                            output += "<div class='result-item__title'>" + item.name + "</div></div>";

                            if (item.description) {
                                output += "<div class='result-item__description'>" + item.description + "</div>";
                            }

                            if (item.featured_image_thumb) {
                                output += "</div>"; // closing tag for 'result-item__meta'
                            }

                            output += "</div>";
                            result_set_wrapper.append(output);
                        })
                    }
                }
            });
        }
    </script>
@endsection

