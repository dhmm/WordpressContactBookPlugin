
function editContact(id) {
    jQuery('#contactIdToEdit').val(id);
    loadContact(id);    
}

jQuery(document).ready(function($){
    $('#dhmmCBFormEdit').submit( function (e){             
         e.preventDefault(); 
         let id = $('#contactIdToEdit').val();         
         let serialized = $('#dhmmCBFormEdit').serialize(); 

         var data = {
            action: 'edit_contact',  
            id : id,          
            contact: serialized
         };
         jQuery.post
         (
             ajaxObject.ajaxUrl, 
             data, 
             function(responseData) {   
                let response = JSON.parse(responseData);                                        
                if(response.error == true ) {
                    alert('Error : '+response.message);
                } else {
                    tb_remove();
                    loadContacts();                        
                }
             }
          );
    })
 });