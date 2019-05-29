<?php   
    global $wpdb;
    $tableName = $wpdb->prefix.'contacts';
    $result = $wpdb->get_results(
        "SELECT * FROM ".$tableName
    );    
?>
<div class="wrap">
    <h2><img src="<?=plugin_dir_url(__FILE__) . '/icon.png'?>"/> Contact Book</h2>
</div>
<div class="wrap">
    <a href="#TB_inline?&width=600&height=550&inlineId=createForm" class="thickbox dhmmCBbtn">Add</a>    
    <a href="#TB_inline?&width=600&height=550&inlineId=editForm" class="thickbox dhmmCBbtn">Remove All</a>
    <input type="text"/>
    <a href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox dhmmCBbtn">Search</a>
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
        <tbody>
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
                    <a href="#TB_inline?&width=600&height=550&inlineId=editForm" class="thickbox dhmmCBbtn">Edit</a>&nbsp;
                    <a href="#TB_inline?&width=600&height=550&inlineId=deleteConfirmForm" class="thickbox dhmmCBbtn dhmmCBredBtn">Delete</a>                    
                </td>            
            </tr>
            <?php $line++; } ?>
        </tbody>
        <?php } ?>
    </table>    
</div>
<?php add_thickbox(); ?>
<div id="createForm" style="display:none;">
     <p>
          Create form
     </p>
</div>
<div id="editForm" style="display:none;">
     <p>
          Edit form
     </p>
</div>
<div id="deleteConfirmForm" style="display:none;">
     <p>
          Delete
     </p>
</div>
