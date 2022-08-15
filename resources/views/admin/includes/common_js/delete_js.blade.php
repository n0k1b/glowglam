$(document).on("click",".delete",function(e){
    e.preventDefault();
    let id = $(this).data("id");
    let route_name = "{{route($route_name)}}";

    if (!confirm('Are you sure you want to continue?')) {
        alert(false);
    }else{
        $.ajax({
            url: route_name,
            type: "GET",
            data: {id:id},
            success: function(data){
                $('#alert_message').fadeIn("slow");
                if(data.success){
                    $('#dataListTable').DataTable().ajax.reload();
                    $('#alert_message').addClass('alert alert-success').html(data.success);
                }
                else if (data.demo) {
                    $('#alert_message').addClass('alert alert-danger').html(data.demo);
                }
                setTimeout(function() {
                    $('#alert_message').fadeOut("slow");
                }, 3000);
            }
        });
    }
});
