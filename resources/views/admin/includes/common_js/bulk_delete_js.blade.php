$("#bulkDelete").on("click",function(){
    var idsArray = [];
    let table = $('#dataListTable').DataTable();
    idsArray = table.rows({selected: true}).ids().toArray();
    let route_name_bulk_delete = "{{route($route_name_bulk_delete)}}";

    if(idsArray.length === 0){
        alert("Please Select at least one checkbox.");
    }else{
        $('#bulkDeleteModal').modal('show');
        let action_type;

        $("#bulkDeleteAll").on("click",function(){
            $.ajax({
                url: "{{route($route_name_bulk_delete)}}",
                method: "GET",
                data: {idsArray:idsArray},
                success: function (data) {
                    console.log(data);
                    if(data.success){
                        $('#bulkDeleteModal').modal('hide');
                        table.rows('.selected').deselect();
                        $('#dataListTable').DataTable().ajax.reload();
                        $('#alert_message').fadeIn("slow"); //Check in top in this blade
                        $('#alert_message').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#alert_message').fadeOut("slow");
                        }, 3000);
                    }
                    else if (data.demo) {
                        $('#bulkDeleteModal').modal('hide');
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
    }
});
