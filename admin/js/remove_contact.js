function removeContact(id) {  
    var data = {
    action: 'remove_contact' ,
    id: id
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