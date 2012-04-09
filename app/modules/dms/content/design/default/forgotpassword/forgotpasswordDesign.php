<h1>Forgot Password</h1>
A new password will be generated for you and sent to the email address<br>
associated with your account, all you have to do is enter your
username.<br><br>
<?php echo $dmsForm -> error("user"); ?>
<form action="process.php" method="POST">
<b>Username:</b> <input type="text" name="user" maxlength="30" value="<?php $dmsForm->value("user"); ?>">
<input type="hidden" name="subforgot" value="1">
<input type="submit" value="Get New Password">
</form>