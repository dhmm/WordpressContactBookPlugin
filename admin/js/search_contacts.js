function searchContacts() { 
    let keyword = jQuery('#searchBox').val();
    var data = {
        action: 'search_contacts',
        keyword : keyword
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