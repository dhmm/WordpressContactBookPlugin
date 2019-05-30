<?php
function getContactTrLine($line , $contact) {
    $style = "";
    if($line%2 == 0 ) {
        $style = 'style="background:#e2e2e2;"';
    }
return <<<HTML
<tr $style>
    <td>$contact->surname</td>
    <td>$contact->name</td>
    <td>$contact->address</td>
    <td>$contact->phone_1</td>
    <td>$contact->phone_2</td>    
    <td>                    
        <a onClick="editContact($contact->id)" href="#TB_inline?&width=600&height=550&inlineId=editForm" class="thickbox dhmmCBbtn">Edit</a>&nbsp;        
        <a onClick="removeContact($contact->id)" href="#" class="dhmmCBbtn dhmmCBredBtn">Delete</a>                                 
    </td>            
HTML;
}
