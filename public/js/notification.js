$(function () {
    var notifApi = APP_URL+"/notification/"+_ID;
    $.ajax({
        type: "GET",
        url: notifApi,
        cache: false,
        success: function(data){
            if (data.data.length > 0) {
                $( "#notification_count").text(data.data.length)
            }
            $.each(data.data, function( index, value ) {
                // console.log(JSON.stringify(value))
                $( "#notification" ).append("<a class=\"dropdown-item d-flex align-items-center\" href="+APP_URL+"/detail/"+value.discuss_letter_id+">\n" +
                    "                    <div class=\"mr-3\">\n" +
                    "                        <div class=\"icon-circle bg-primary\">\n" +
                    "                            <i class=\"fas fa-file-alt text-white\"></i>\n" +
                    "                        </div>\n" +
                    "                    </div>\n" +
                    "                    <div>\n" +
                    "                        <div class=\"small text-gray-500\">"+value.created_date+"</div>" +
                    "                        <span class=\"font-weight-bold\">"+value.email+" menambahkan komentar"+"</span>\n" +
                    "                    </div>\n" +
                    "                </a>" );
            });
        },
        error: function (e) {
            // console.log(e.statusText)
        }
    });
});
