$(document).on("click",".active",function(e){
    e.preventDefault();
    var id = $(this).data("id");
    let route_name = "{{route($route_name)}}";

    $.ajax({
        url: route_name,
        type: "GET",
        data: {id:id},
        success: function(data){
            console.log(data);
            if (data.demo) {
                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                $('#alert_message').addClass('alert alert-danger').html(data.demo);
                setTimeout(function() {
                    $('#alert_message').fadeOut("slow");
                }, 3000);
            }
            else if(data.success){
                $('#dataListTable').DataTable().ajax.reload();
                $('#alert_message').fadeIn("slow"); //Check in top in this blade
                $('#alert_message').addClass('alert alert-success').html(data.success);
                setTimeout(function() {
                    $('#alert_message').fadeOut("slow");
                }, 3000);
            }
        }
    });
});
