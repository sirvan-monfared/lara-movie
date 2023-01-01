(function(){
    /**
     * Report
     */
    var portlet_wrapper = $("#report-portlet");
    var report_form = $("#report-form");
    var report_result = $("#report-result");
    var report_submit = report_form.find('button').first();

    /**
     *  Chart
     */
    var month_wrapper = $("#month-picker");
    var year_wrapper = $("#year-picker");
    var selected_month = month_wrapper.find("#selected-value").attr('data-value');
    var selected_year = year_wrapper.find("#selected-value").attr('data-value');

    /**
     * Calculate order report
     */
    report_form.on("submit", function(e) {
        e.preventDefault();

        blockElement(portlet_wrapper);
        addButtonLoading(report_submit);


        $.ajax({
            url : 'process/ajax_calls.php',
            dataType : 'json',
            type : 'post',
            data : {
                action: "calculate-income-report",
                from_date: $("#from").val(),
                to_date: $("#to").val(),
            },

            success : function(response){
                unblockElement(portlet_wrapper);
                removeButtonLoading(report_submit);

                if (response.status) {

                    report_result.text(response.income);
                } else {
                    errorToast(response.errors)
                }
            }
        });
    });


    /**
     * handle Chart
     */
    month_wrapper.find(".m-nav__item").on("click", function(e) {
        e.preventDefault();
        selected_month = $(this).attr('data-value');
        redirectUrl(selected_month, selected_year);
    });
    year_wrapper.find(".m-nav__item").on("click", function(e) {
        e.preventDefault();
        selected_year = $(this).attr('data-value');
        redirectUrl(selected_month, selected_year);
    });

    /**
     * Function to redirect after clicking on year or month
     *
     * @param month
     * @param year
     */
    function redirectUrl(month, year) {
        redirectTo(Globe__page_url+ "?month="+ month + "&year="+ year);
    }

})();