var Inbox = function (page_num) {
    var content = $('.inbox-content');
    var loading = $('.inbox-loading');
    var includes_root = (Globe__mailbox_type === 'sms') ? 'includes/mailbox/sms/' : 'includes/mailbox/email/';
    var type_name = (Globe__mailbox_type === 'sms') ? ' پیامک ' : '  ';

    var loadInbox = function (el, name) {
        var url = includes_root + name + '_mail.php';
        var title = $('.inbox-nav > li.' + name + ' a').attr('data-title');

        loading.show();
        content.html('');
        toggleButton(el);
        page_num = GLOBE__page_number;
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            //dataType: "html",
            data: {page: page_num},
            success: function (res) {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-nav > li.' + name).addClass('active');
                $('.inbox-header > h1').text(title);

                loading.hide();
                content.html(res);
                // App.fixContentHeight();
                // App.initUniform();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toggleButton(el);
            },
            async: false
        });
    };

    var loadMessage = function (el, name, resetMenu) {
        var url = includes_root + 'inbox_mail_view.php';
        loading.show();
        content.html('');
        toggleButton(el);
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            data: {mailId: mailId},
            success: function (res) {
                toggleButton(el);

                if (resetMenu) {
                    $('.inbox-nav > li.active').removeClass('active');
                }
                $('.inbox-header > h1').text('');

                loading.hide();
                content.html(res);
                // App.fixContentHeight();
                // App.initUniform();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toggleButton(el);
            },
            async: false
        });
    };

    var initTags = function (input) {
        initiateSelect2Tags();

        // input.tag({
        //     autosizedInput: true,
        //     containerClasses: 'span12',
        //     inputClasses: 'm-wrap',
        //     source: function (query, process) {
        //         return [
        //             'Bob Nilson <bob.nilson@metronic.com>',
        //             'Lisa Miller <lisa.miller@metronic.com>',
        //             'Test <test@domain.com>',
        //             'Dino <dino@demo.com>',
        //             'Support <support@demo.com>']
        //     }
        // });
    };

    var initWysihtml5 = function () {
        $('.inbox-wysihtml5').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['misc', ['fullscreen', 'undo', 'redo']],
            ]
        });
    };

    var loadCompose = function (el) {
        var url = includes_root + 'inbox_compose.php';

        loading.show();
        content.html('');
        toggleButton(el);

        // load the form via ajax
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function (res) {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('ارسال ' + type_name);

                loading.hide();
                content.html(res);

                initTags($('[name="to"]'));
                initWysihtml5();
                initRemoteSelect();

                $('.inbox-wysihtml5').focus();
                // App.fixContentHeight();
                // App.initUniform();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toggleButton(el);
            },
            async: false
        });
    };

    var loadReply = function (el) {
        var url = includes_root + 'inbox_reply.php';

        loading.show();
        content.html('');
        toggleButton(el);

        // load the form via ajax
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            data: {mailId: mailId},
            success: function (res) {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('ارسال پاسخ');

                loading.hide();
                content.html(res);
                $('[name="message"]').val($('#reply_email_content_body').html());

                initTags($('[name="to"]')); // init "TO" input field
                handleCCInput(); // init "CC" input field

                initWysihtml5();
                // App.fixContentHeight();
                // App.initUniform();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toggleButton(el);
            },
            async: false
        });
    };

    var loadSearchResults = function (el) {
        var url = 'inbox_search_result.html';

        loading.show();
        content.html('');
        toggleButton(el);

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function (res) {
                toggleButton(el);

                $('.inbox-nav > li.active').removeClass('active');
                $('.inbox-header > h1').text('Search');

                loading.hide();
                content.html(res);
                App.fixContentHeight();
                App.initUniform();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                toggleButton(el);
            },
            async: false
        });
    };

    var handleCCInput = function () {
        var the = $('.inbox-compose .mail-to .inbox-cc');
        var input = $('.inbox-compose .input-cc');
        the.hide();
        input.show();
        initTags($('[name="cc"]'), -10);
        $('.close', input).click(function () {
            input.hide();
            the.show();
        });
    };

    var handleBCCInput = function () {

        var the = $('.inbox-compose .mail-to .inbox-bcc');
        var input = $('.inbox-compose .input-bcc');
        the.hide();
        input.show();
        initTags($('[name="bcc"]'), -10);
        $('.close', input).click(function () {
            input.hide();
            the.show();
        });
    };

    var toggleButton = function (el) {
        if (typeof el != 'undefined') {
            return;
        }
        if (el.attr("disabled")) {
            el.attr("disabled", false);
        } else {
            el.attr("disabled", true);
        }
    };

    var paginate = function () {
        // pagination
        $('body').on('click', 'pagenav', function (e) {
            e.preventDefault();
            var content = $('.inbox-content');
            var loading = $('.inbox-loading');

            var name = $(this).attr('type'); // type of page (inbox or sent)

            var url = includes_root + name + '_mail.php';
            title = $('.inbox-nav > li.' + name + ' a').attr('data-title');

            loading.show();
            content.html('');

            $.ajax({
                type: "GET",
                cache: false,
                url: url,
                data: {
                    page: $(this).attr('data') //page number
                },
                success: function (res) {
                    $('.inbox-nav > li.active').removeClass('active');
                    $('.inbox-nav > li.' + name).addClass('active');
                    $('.inbox-header > h1').text(title);

                    loading.hide();
                    content.html(res);
                    App.fixContentHeight();
                    App.initUniform();
                },
                async: false
            });
        })
    };

    return {
        //main function to initiate the module
        init: function () {

            // handle compose btn click
            $('body').on('click', '.inbox .compose-btn a', function () {
                loadCompose($(this));
            });

            // handle reply and forward button click
            $('body').on('click', '.inbox .reply-btn', function () {
                loadReply($(this));
            });

            // handle view message
            $('body').on('click', '.inbox-content .view-message', function () {
                window.mailId = $(this).attr("name"); // global variable
                loadMessage($(this));
            });

            // handle inbox listing
            $('.inbox-nav > li.inbox > a').click(function () {
                loadInbox($(this), 'inbox');
            });

            // handle sent listing
            $('.inbox-nav > li.sent > a').click(function () {
                loadInbox($(this), 'sent');
            });

            // handle draft listing
            $('.inbox-nav > li.draft > a').click(function () {
                loadInbox($(this), 'draft');
            });

            // handle trash listing
            $('.inbox-nav > li.trash > a').click(function () {
                loadInbox($(this), 'trash');
            });

            //handle compose/reply cc input toggle
            $('body').on('click', '.inbox-compose .mail-to .inbox-cc', function () {
                handleCCInput();
            });

            //handle compose/reply bcc input toggle
            $('body').on('click', '.inbox-compose .mail-to .inbox-bcc', function () {
                handleBCCInput();
            });

            //handle loading content based on URL parameter
            if (getURLParameter("a") === "view") {
                loadMessage();
            } else if (getURLParameter("a") === "compose") {
                loadCompose();
            } else {
                $('.inbox-nav > li.inbox > a').click();
            }

            paginate();
        }

    };

    function getURLParameter (paramName) {
        var searchString = window.location.search.substring(1),
            i, val, params = searchString.split("&");

        for (i = 0; i < params.length; i++) {
            val = params[i].split("=");
            if (val[0] == paramName) {
                return unescape(val[1]);
            }
        }
        return null;
    }

}();