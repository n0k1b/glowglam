$("#bulk_action").on("click",function(){
    var idsArray = [];
    let table = $('#dataListTable').DataTable();
    idsArray = table.rows({selected: true}).ids().toArray();
    let route_name_bulk_active_inactive = "{{route($route_name_bulk_active_inactive)}}";
    @if (isset($route_name_bulk_delete))
        let route_name_bulk_delete = "{{route($route_name_bulk_delete)}}";
    @endif


    if(idsArray.length === 0){
        alert("Please Select at least one checkbox.");
    }else{
        $('#bulkConfirmModal').modal('show');
        let action_type;

        $("#active").on("click",function(){
            console.log(idsArray);
            action_type = "active";
            $.ajax({
                url: route_name_bulk_active_inactive,
                method: "GET",
                data: {idsArray:idsArray,action_type:action_type},
                success: function (data) {
                    if(data.success){
                        $('#bulkConfirmModal').modal('hide');
                        table.rows('.selected').deselect();
                        $('#dataListTable').DataTable().ajax.reload();
                        $('#alert_message').fadeIn("slow"); //Check in top in this blade
                        $('#alert_message').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#alert_message').fadeOut("slow");
                        }, 3000);
                    }
                    else if (data.demo) {
                        $('#bulkConfirmModal').modal('hide');
                        $('#alert_message').fadeIn("slow"); //Check in top in this blade
                        $('#alert_message').addClass('alert alert-danger').html(data.demo);
                        setTimeout(function() {
                            $('#alert_message').fadeOut("slow");
                        }, 3000);
                    }

                }
            });
        });
        $("#inactive").on("click",function(){
            action_type = "inactive";
            console.log(idsArray);
            $.ajax({
                url: route_name_bulk_active_inactive,
                method: "GET",
                data: {idsArray:idsArray,action_type:action_type},
                success: function (data) {
                    if(data.success){
                        $('#bulkConfirmModal').modal('hide');
                        table.rows('.selected').deselect();
                        $('#dataListTable').DataTable().ajax.reload();
                        $('#alert_message').fadeIn("slow"); //Check in top in this blade
                        $('#alert_message').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#alert_message').fadeOut("slow");
                        }, 3000);
                    }
                    else if (data.demo) {
                        $('#bulkConfirmModal').modal('hide');
                        $('#alert_message').fadeIn("slow"); //Check in top in this blade
                        $('#alert_message').addClass('alert alert-danger').html(data.demo);
                        setTimeout(function() {
                            $('#alert_message').fadeOut("slow");
                        }, 3000);
                    }
                }
            });
        });

        @if (isset($route_name_bulk_delete))
            $("#bulkDelete").on("click",function(){
                $.ajax({
                    url: "{{route($route_name_bulk_delete)}}",
                    method: "GET",
                    data: {idsArray:idsArray},
                    success: function (data) {
                        console.log(data);
                        if(data.success){
                            $('#bulkConfirmModal').modal('hide');
                            table.rows('.selected').deselect();
                            $('#dataListTable').DataTable().ajax.reload();
                            $('#alert_message').fadeIn("slow"); //Check in top in this blade
                            $('#alert_message').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#alert_message').fadeOut("slow");
                            }, 3000);
                        }
                        else if (data.demo) {
                            $('#bulkConfirmModal').modal('hide');
                            $('#dataListTable').DataTable().ajax.reload();
                            $('#alert_message').fadeIn("slow"); //Check in top in this blade
                            $('#alert_message').addClass('alert alert-danger').html(data.demo);
                            setTimeout(function() {
                                $('#alert_message').fadeOut("slow");
                            }, 3000);
                        }
                    }
                });
            });
        @endif

    }
});
