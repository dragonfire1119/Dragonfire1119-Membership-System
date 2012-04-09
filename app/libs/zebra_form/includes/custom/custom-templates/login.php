<?php
    // don't forget about this for custom templates, or errors will not show for server-side validation
    // $error is the name of the variable used with the set_rule method
    echo (isset($error) ? $error : '');
?>

<div class="row">
    <div class="cell">
        <?php echo $label_email . $email?>
    </div>
    <div class="cell">
        <?php echo $label_password . $password?>
    </div>
    <div class="clear" style="margin-bottom:10px"></div>
    <div class="cell"><?php echo $remember_me_yes?></div>
    <div class="cell"><?php echo $label_remember_me_yes?></div>
    <div class="clear"></div>
</div>
<div class="row last">
    <?php echo $btnsubmit?>
</div>
