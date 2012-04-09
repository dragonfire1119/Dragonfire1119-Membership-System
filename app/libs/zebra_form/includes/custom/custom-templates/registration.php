<?php
// don't forget about this for custom templates, or errors will not show for server-side validation
// $error is the name of the variable used with the set_rule method
echo(isset($error) ? $error : '');
?>
<div class="row">
	<div class="cell">
		<?php echo $label_firstname . $firstname
		?>
	</div>
	<div class="cell">
		<?php echo $label_lastname . $lastname
		?>
	</div>
	<div class="clear"></div>
</div>
<div class="row even">
	<?php echo $label_email . $email . $note_email
	?>
</div>
<div class="row">
	<div class="cell">
		<?php echo $label_password . $password . $note_password
		?>
	</div>
	<div class="cell">
		<?php echo $label_confirm_password . $confirm_password
		?>
	</div>
	<div class="clear"></div>
</div>
<div class="row even">
	<div class="cell">
		<?php echo $label_dateofbirth?>
	</div>
	<div class="cell">
		<?php echo $day?>
	</div>
	<div class="cell">
		<?php echo $month?>
	</div>
	<div class="cell">
		<?php echo $year?>
	</div>
	<div class="clear"></div>
</div>
<div class="row">
	<?php echo $captcha_image . $label_captcha_code . $captcha_code . $note_captcha
	?>
	<div class="clear"></div>
</div>
<div class="row even last">
	<?php echo $btnsubmit
	?>
</div>