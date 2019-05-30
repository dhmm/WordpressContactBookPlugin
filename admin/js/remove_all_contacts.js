function removeAllContacts() {  
    var data = {
    action: 'remove_all_contacts'
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
                loadContacts();                               
            }
        }
    );  
}