<?php   
    global $wpdb;
    $tableName = $wpdb->prefix.'contacts';
    $result = $wpdb->get_results(
        "SELECT * FROM ".$tableName
    );    
?>
<div class="wrap">
    <h2 onclick="test()"><img src="<?=DHMMCB_PLUGIN_URL.'admin/images/icon.png'?>"/> Contact Book</h2>
</div>
<div class="wrap">
    <a href="#TB_inline?&width=600&height=450&inlineId=createForm" class="thickbox dhmmCBbtn">Add</a>    
    <a onClick="removeAllContacts()" href="#" class="dhmmCBbtn">Remove All</a>
    <input id ="searchBox" onKeyUp ="searchContacts()" type="text"/>
    <a onClick ="clearSearch()" href="#" class="dhmmCBbtn dhmmCBredBtn">X</a> 
</div>

<div class="wrap">
    <table class="widefat fixed dhmmCBTable">
        <thead >
            <tr>
                <th>Surname</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone 1</th>
                <th>Phone 2</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php if($result) { ?>
        <tbody id="tbodyContacts">
            <?php 
            $line=1;
            foreach($result as $contact) { ?>
            <tr <?=($line % 2 == 0 ? 'style="background:#e2e2e2;"' : '')?>>
                <td><?=$contact->surname?></td>
                <td><?=$contact->name?></td>
                <td><?=$contact->address?></td>
                <td><?=$contact->phone_1?></td>
                <td><?=$contact->phone_2?></td>    
                <td>                    
                    <a onClick="editContact(<?=$contact->id?>)" href="#TB_inline?&width=600&height=550&inlineId=editForm" class="thickbox dhmmCBbtn">Edit</a>&nbsp;
                    <a onClick="removeContact(<?=$contact->id?>)" href="#" class="dhmmCBbtn dhmmCBredBtn">Delete</a>                    
                </td>            
            </tr>
            <?php $line++; } ?>
        </tbody>
        <?php } ?>
    </table>    
</div>
<?php 
add_thickbox(); 
include DHMMCB_PLUGIN_DIR.'/admin/includes/create_form.php';
include DHMMCB_PLUGIN_DIR.'/admin/includes/edit_form.php';                                       
?>


