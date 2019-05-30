    jQuery(document).ready(function($){
        $('#dhmmCBFormCreate').submit( function (e){             
             e.preventDefault();  
             let serialized = $('#dhmmCBFormCreate').serialize();                               
             var data = {
                action: 'create_contact',
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