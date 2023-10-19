

async function validConfirm(id){
    
    if (confirm('Voulez-vous vraiment valider ce témoignage?')) {

        Confirm(id);
    }
}
async function deleteConfirm(id){
    
    if (confirm('Voulez-vous vraiment supprimer ce temoignage?')) {

        Delete(id);
    }
}
function Open(id) { 

    window.open("/admin/temoignages/edit/"+ id ,"_self");
}
function Confirm(id) {

    var value = $(this).attr('data-value');
    $.ajax({
        url: '/admin/temoignages/confirm/' + id,
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
function Delete(id) {

        var value = $(this).attr('data-value');
        $.ajax({
            url: '/admin/temoignages/delete/' + id,
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
