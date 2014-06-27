<?php session_start();
if (isset($_SESSION['user_loggedin'])) {
    header('Location: /sandbox/colin/dashboard.php');
    exit;
};
$_SESSION['token'] = md5(uniqid(microtime(), true));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Colin J's Grocery Login</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/site.css">

</head>
<body>

<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-push-2">
                <h1>Colin J's Grocery List</h1>
                <p class="lead">
                    A fun excursion in writing grocery lists with PHP, MySQL and AngluarJS
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-push-2">
            <?php if(isset($_SESSION['error_message'])) { ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error_message']; ?>
                </div>
            <?php } ?>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                <li><a href="#register" data-toggle="tab">Register</a></li>
            </ul>
            <div class="tab-content">
                <div id="login" class="well tab-pane fade in active">
                    <form method="post" action="dashboard.php?action=login">
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <input type="text" name="username" placeholder="Your Username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" placeholder="Your Password" class="form-control">
                        </div>
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                        <input type="submit" class="btn btn-primary" value="Submit!">
                    </form>
                </div>
                <div id="register" class="well tab-pane fade">
                    <form method="post" action="dashboard.php?action=register">
                        <div class="form-group">
                            <label class="control-label">Username <span class="text-muted">Letters and numbers only</span></label>
                            <input type="text" name="username" placeholder="Your Username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password <span class="text-muted">Letters and numbers only, minimum 6 characters</span></label>
                            <input type="password" name="password" placeholder="Your Password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" name="password-verify" placeholder="Verify Your Password" class="form-control">
                        </div>
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                        <input type="submit" class="btn btn-primary" value="Submit!">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>

</body>
</html>