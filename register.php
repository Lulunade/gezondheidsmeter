<?php
session_start();
// get classes db and sql
require ('classes/db.php');
require ('classes/sql.php');

// get the informaion of the database
$database = new Dbconfig();
// start connection
$db = $database->getConnection();

// give the connection to the sql class do sql can get executed
$sqlQuery = new Sql($db);

// if user registerd (did a post) execute this script
if (isset($_POST['Register']) && $_POST['Register'] == 'Register') {
    // get all the info in the post 
    $gebruikersnaam = $_POST['Username'];
    $leeftijd = $_POST['Age'];
    $email = $_POST['emailadress'];
    $wachtwoord = $_POST['Password'];
    $herhaalWachtwoord = $_POST['PasswordRepeat'];

    // check if email is an email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // check if age is a number
        if (is_numeric($leeftijd) == 1) {
            // chceck if email already is used
            $response = $sqlQuery->UserExists($email);
            // if user exists give a error
            if ($response->fetchColumn() > 0) {
                $doAlert = 'failedUserExists';
            } else if ($wachtwoord == $herhaalWachtwoord) {
                $eWachtwoord = password_hash($wachtwoord, PASSWORD_BCRYPT);
                $response = $sqlQuery->UserInsert($gebruikersnaam, $leeftijd, $email, $eWachtwoord);
                $_SESSION['loggedIn'] = 1;
                //$_SESSION['name'] = $name;
                //$_SESSION['email'] = $email;
                //$_SESSION['userID'] = $data['id'];
                //$_SESSION['doAlert'] = "true";
                header('Location: index');
                exit();
            } else {
                $doAlert = 'passwordError';
            }
        } else {
            $doAlert = 'failedEmail';
        }
    }
}
?>
<!doctype html>
<html lang="nl">
<head>
    <?php include_once("layouts/head.php")?>
</head>
<body>
<?php include_once("layouts/navbar.php")?>
<div class="container" style="margin-bottom: 8.1em">
    <div class="container border border-dark">
        <div class="row">
            <h1>Registreren</h1>
            <div class="col-md-8">
                <div class="row">
                    <form id="Register" method="post" class=".form-inline .form-horizontal">
                        <div class="form-group row mb-4">
                            <div class="col-3">
                                <label class="control-label" data-placeholder="Gebruikersnaam" for="Username">Gebruikersnaam:</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="Username" class="form-control" id="Username" required>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-3">
                            <label class="control-label" data-placeholder="Leeftijd" for="Age">Leeftijd:</label>
                            </div>
                            <div class="col-sm-8">
                                    <input type="number" name="Age" class="form-control" id="Age" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-3">
                            <label class="control-label" data-placeholder="Wachtwoord" for="Password">Wachtwoord:</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="password" name="Password" class="form-control" id="Password" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-3">
                            <label class="control-label" data-placeholder="Herhaal wachtwoord" for="PasswordRepeat">Herhaal Wachtwoord:</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="password" name="PasswordRepeat" class="form-control" id="PasswordRepeat" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-3">
                            <label class="control-label" data-placeholder="Email" for="emailadress">Email:</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="email" name="emailadress" class="form-control" id="emailadress" required>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-3">
                            </div>
                            <div class="col-sm-8">
                                <input type="submit" id="submit" name="Register" value="Register" class="btn btn-light px-5 border border-dark float-end">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/SweetAlerts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.11.1/dist/sweetalert2.all.min.js"></script>
<script>
    var doAlert = "<?php echo $doAlert ?? ""; ?>";
    $(document).ready(function() {
        if (doAlert === "failedUserExists") {
            alreadyExists();
        } else if (doAlert === "passwordError") {
            passwordError();
        }else if (doAlert === "failedEmail"){
            wrongEmail();

        }else if (doAlert === "ageError"){
            ageError();
        }
    });
</script>
<?php include_once("layouts/footer.php")?>
</body>
</html>