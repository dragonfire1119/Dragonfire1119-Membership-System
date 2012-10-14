<?php require_once 'admin-header.php'; ?>
<?php require_once 'admin-header-menu.php'; ?>
<?php
$id = $_GET['user_id'];
$user = R::load('users', $id);
?>
    <div class="span12">
        <h3>Edit User <a id="tooltip" data-original-title="Click here to cancel editing User" class="btn btn-mini" href="user-new.php" rel="tooltip" data-placement="bottom">Add New</a></h2>
            <hr />
            <form class="form-horizontal" method="post" action="">
                <div class="control-group">
                    <label class="control-label" for="inputUsername">Username (required)</label>
                    <div class="controls">
                        <input type="text" id="inputUsername" placeholder="Username..." value="<?php echo $user->username; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">E-mail (required)</label>
                    <div class="controls">
                        <input type="text" id="inputEmail" placeholder="Email..." value="<?php echo $user->email; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputFirstname">First Name</label>
                    <div class="controls">
                        <input type="text" id="inputFirstname" placeholder="Firstname..." value="<?php echo $user->firstname; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputLastname">Last Name</label>
                    <div class="controls">
                        <input type="text" id="inputLastname" placeholder="Lastname..." value="<?php echo $user->lastname; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputWebsite">Website</label>
                    <div class="controls">
                        <input type="text" id="inputWebsite" placeholder="Website..." value="<?php echo $user->website; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPassword">New Password</label>
                    <div class="controls">
                        <input type="password" id="inputPassword" placeholder="Password..."><br />
                        <input type="password" id="inputPasswordconfirm" placeholder="Password Confirm...">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPassword">Role</label>
                    <div class="controls">
                        <?php $roles = array("1" => "admin", "2" => "user"); ?>
                        <select name="role">
                            <?php foreach ($roles as $key => $value) { ?>
                            <option><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Update User</button>
                    </div>
                </div>
            </form>
    </div>
    <hr />
<?php require_once 'admin-footer.php'; ?>