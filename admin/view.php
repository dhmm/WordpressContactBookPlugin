<?php
    wp_enqueue_style('dhmm_cb');
    
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
    <a href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox dhmmCBbtn">Remove All</a>
    <input type="text"/>
    <a href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox dhmmCBbtn">Search</a>
</div>

<div class="wrap">
    <table class="widefat fixed">
        <thead >
            <tr style="background:#123456;">
                <th style="color:#fff;">Surname</th>
                <th style="color:#fff;">Name</th>
                <th style="color:#fff;">Address</th>
                <th style="color:#fff;">Phone 1</th>
                <th style="color:#fff;">Phone 2</th>
                <th style="color:#fff;">Action</th>
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
                <td><button class="dhmmCBbtn">Edit</button>&nbsp;<button class="dhmmCBbtn dhmmDBredBtn">Delete</button></td>            
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
<div id="createForm" style="display:none;">
     <p>
          Edit form
     </p>
</div>
