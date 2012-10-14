<?php require_once 'admin-header.php'; ?>
<?php require_once 'admin-header-menu.php'; ?>
<div class="span12">
    <h3>Users <a id="tooltip" data-original-title="Click here to Add a New User" class="btn btn-mini" href="user-new.php" rel="tooltip" data-placement="bottom">Add New</a></h2>
        <hr />
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td><a href="user-edit.php"><i id="tooltip-edit" data-original-title="Edit This User?" rel="tooltip" data-placement="top" class="icon-edit"></i></a> <a href=""><i id="tooltip-delete" data-original-title="Delete This User?" rel="tooltip" data-placement="top" class="icon-fire"></i></a></td>
                </tr>
            </tbody>
        </table>
</div>
<hr />
<?php require_once 'admin-footer.php'; ?>