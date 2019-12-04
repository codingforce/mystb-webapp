function sendMail() {
    console.log("drin");
    jQuery.ajax({
        url: "/start/sendmail/",
        type: "post",
        data: {data: $('#stbform').serialize()},
        beforeSend: function(){
            $('#send').hide();
            $('#spinner').show();
        },
        success: function (data) {

        },
        complete: function () {
            $('#spinner').hide();
            $('#send').show();
        }
    });
}