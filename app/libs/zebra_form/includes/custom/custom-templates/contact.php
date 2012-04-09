<?php
    // don't forget about this for custom templates, or errors will not show for server-side validation
    // $error is the name of the variable used with the set_rule method
    echo (isset($error) ? $error : '');
?>
<div class="row">
    <div class="cell"><?php echo $label_name . $name?></div>
    <div class="cell"><?php echo $label_email . $email?></div>
    <div class="clear"></div>
</div>
<div class="row even">
    <?php echo $label_subject . $subject?>
</div>
<div class="row">
    <?php echo $label_message . $message?>
</div>
<div class="row even last">
    <?php echo $btnsubmit?>
</div>