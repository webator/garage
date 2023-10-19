
async function deleteConfirm(ParamId){
    
    if (confirm('Voulez-vous vraiment supprimer ce service?')) {
        Delete(ParamId);
    }
}
function Open(id) { 
    window.open("/admin/services/edit/"+ id ,"_self");
}

function Delete(id) {
        var value = $(this).attr('data-value');
        $.ajax({
            url: '/admin/services/delete/' + id,
            success: function(response) {
            $('#status').text(response);
            window.location.reload();
            },
            error: function(xhr, status, error) {
                $('#status').text('Error');
            console.log(error);
            }            
        });
        
    
}
