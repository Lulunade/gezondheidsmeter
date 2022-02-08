<?php
session_start();
if(!empty($_SESSION['loggedIn'])){
    header('Location: dashboard.php');
}
$_SESSION['loggedIn'] = 0;
require ('classes/db.php');
require ('classes/sql.php');
$database = new Dbconfig();
$db = $database->getConnection();
$sqlQuery = new Sql($db);
if (isset($_POST['Login']) && $_POST['Login'] == 'Login') {
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $bool =$sqlQuery->UserLogin($email, $password);
        if($bool === true){
            $_SESSION['loggedIn'] = 1;
            $_SESSION['email'] = $email;
            $_SESSION['doAlert'] = "true";
            header('Location: dashboard.php');
            exit();
        }else {
            $doAlert = 'notlogin';
        }
    } else
        $doAlert = 'notlogin';
}
?>
<!doctype html>
<html lang="nl">

<head>
    <?php include_once("layouts/head.php")?>
</head>

<body>
    <?php include_once("layouts/navbar.php")?>
    <div style="margin-bottom: 19.8em">
        <div class="container border border-dark">
            <div class="row">
                <h1>Aanmelden</h1>
                <div class="col-md-8">
                    <div class="row">
                        <form id="Login" method="post" class=".form-inline .form-horizontal">
                            <div class="form-group row mb-4">
                                <div class="col-3">
                                    <label class="control-label" data-placeholder="Email" for="Email">Email:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="email" name="Email" class="form-control" id="Email" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-3">
                                    <label class="control-label" data-placeholder="Wachtwoord"
                                        for="Password">Wachtwoord:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="password" name="Password" class="form-control" id="Password" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <div class="col-3">
                                </div>
                                <div class="col-sm-8">
                                    <input type="submit" id="submit" name="Login" value="Login"
                                        class="btn btn-light px-5 border border-dark float-end">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="images/logo.svg" class="m-auto d-block" alt="logo">
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <?php include_once("layouts/footer.php")?>
    </div class="">

    <script>
        var doAlert = "<?php echo $doAlert ?? ""; ?>";
        $(document).ready(function () {
            if (doAlert === "notlogin") {
                LoginError();
            }
        });
        console.log("<?=$_SESSION['admin'];?>");
    </script>
</body>

</html>