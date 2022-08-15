    e.preventDefault();
    $.ajax({
        url: "{{route($route_name)}}",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function (data) {
            let html = '';
            if (data.errors) {
                html = '<div class="alert alert-danger">';
                for (let count = 0; count < data.errors.length; count++) {
                    html += '<p>' + data.errors[count] + '</p>';
                }
                html += '</div>';
                $('#alert_message').fadeIn("slow");
                $('#alert_message').html(html);
                setTimeout(function() {
                    $('#alert_message').fadeOut("slow");
                }, 3000);
            }
            else if(data.success){
                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                $('#alert_message').addClass('alert alert-success').html(data.success);
                setTimeout(function() {
                    $('#alert_message').fadeOut("slow");
                }, 3000);
            }
        }
    });

