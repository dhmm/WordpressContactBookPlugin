function loadContact(id) {
    jQuery('#btnSaveContact').prop('disabled' , true);
    var data = {
        action: 'load_contact' ,
        id : id
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
                jQuery('#txtSurname').val();
                jQuery('#txtName').val();
                jQuery('#txtAddress').val();
                jQuery('#txtPhone1').val();
                jQuery('#txtPhone2').val();
                jQuery('#txtNotes').val();

                let contact = response.data; 
                jQuery('#txtSurname').val(contact.surname);
                jQuery('#txtName').val(contact.name);
                jQuery('#txtAddress').val(contact.address);
                jQuery('#txtPhone1').val(contact.phone_1);
                jQuery('#txtPhone2').val(contact.phone_2);
                jQuery('#txtNotes').val(contact.notes);

                jQuery('#btnSaveContact').prop('disabled' , false);                               
            }
        }
    );
}