<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">DMS</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active"><a href="index.php"><i class="icon-home icon-white"></i> Dashboard</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#"><i class="icon-user icon-white"></i> Users <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li><a href="users.php"><i class="icon-user icon"></i> All Users</a></li>
                            <li><a href="user-new.php"><i class="icon-pencil icon"></i> Add New</a></li>
                            <li><a href="profile.php"><i class="icon-bookmark icon"></i> Your Profile</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#"><i class="icon-cog icon-white"></i> Settings <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li><a href="options-general.php"><i class="icon-wrench icon"></i> General</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav pull-right">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-user icon"></i> Howdy, <?php if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true) { echo $_COOKIE["username"]; } ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="profile.php"><i class="icon-edit icon"></i> Edit My Profile</a></li>
                            <li><a href="profile.php"><i class="icon-off icon"></i> Logout</a></li>
                        </ul>
                    </div>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container">