function loadContacts() {  
    var data = {
    action: 'load_contacts'
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
                jQuery('#tbodyContacts').html(response.data);                                
            }
        }
    );
  
}