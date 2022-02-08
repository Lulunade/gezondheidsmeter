<?php
session_start();

require ('classes/db.php');
require ('classes/sql.php');
$database = new Dbconfig();
$db = $database->getConnection();
$sqlQuery = new Sql($db);

   if (empty($_SESSION['userID'])){
        header('Location: login');
    }

    $data = $sqlQuery->getUserData($_SESSION['userID']);
   while ($row = $data->fetch()){
       //var_dump($row['Geslacht']);
       $UserName = $row['Naam'];
       $UserEmail = $row['email'];
       $UserHeight = $row['Lengte'];
       $UserWeight = $row['Gewicht'];
       $UserAge = $row['Leeftijd'];
       $Sex = $row['Geslacht'];

    }

    if (isset($_POST['Update'])){

        if($_POST['UserEmail'] == $_POST['RepeatEmail']){
            $UserName = $_POST['UserName'];
            $UserEmail = $_POST['UserEmail'];
            $UserHeight = $_POST['UserHeight'];
            $UserWeight = $_POST['UserWeight'];
            $UserAge = $_POST['UserAge'];
            $Sex = $_POST['inputSex'];
            $sqlQuery->UpdateUser($UserName, $UserEmail, $UserHeight, $UserWeight, $UserAge, $Sex, $_SESSION['userID']);
            $_SESSION["name"]= $UserName;
        }else {
            $doAlert = 'failedEmail';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("layouts/head.php")?>
</head>
<body>
    <?php include_once("layouts/navbar.php")?>
    <?php

    ?>
    <div class="container-fluid row " style="height: 20em;
    padding: 0;
    margin: 0;">
        <div class="border border-dark mb-5 text-white" style="background-image: linear-gradient(to right , darkblue, blue)">
            <div class=" m-3">
                <h2>Welkom <?=$UserName ?></h2>
                <h3>Dit is je profielpagina.</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid  w-75" style="position: relative; bottom: 9em;">
        <form action="" method="post" class="row w-75 border border-dark shadow bg-white">
            <h1 class="mb-5 mt-2">Mijn profiel</h1>
            <div class="form-group col-md-6 mb-3">
                <label class="h4">Gebruikersnaam</label>
                <input class="form-control" type="text" name="UserName" value="<?=$UserName?>">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="h4">Leeftijd</label>
                <input class="form-control" type="text" name="UserAge" value="<?=$UserAge?>">
            </div>
            <div class="form-group mb-3">
                <label class="h4" for="inputSex">Geslacht</label>
                <select name="inputSex" class="form-control" id="sexselect">
                    <option value="Man">Man</option>
                    <option value="Vrouw">Vrouw</option>
                    <option value="Nvt">Nvt</option>
                </select>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="h4">E-mailadres</label>
                <input class="form-control" type="text" name="UserEmail" value="<?=$UserEmail?>">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="h4">Voer E-mailadres opnieuw in</label>
                <input class="form-control" type="text" name="RepeatEmail" value="<?=$UserEmail?>">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="h4">Lengte (in cm)</label>
                <input class="form-control" type="text" name="UserHeight" value="<?=$UserHeight?>">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="h4">Gewicht (in kg)</label>
                <input class="form-control" type="text" name="UserWeight" value="<?=$UserWeight?>">
            </div>
            <div class="col-12 mb-3 ">
                <button type="submit" name="Update" class="btn btn-primary ">Submit</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("sexselect").value = '<?=$Sex?>';


        var doAlert = "<?php echo $doAlert ?? ""; ?>";
        $(document).ready(function() {
            if (doAlert === "failedUserExists") {
                alreadyExists();
            }
            else if (doAlert === "failedEmail"){
                wrongEmail();

            }
        });
    </script>

    <?php include_once("layouts/footer.php")?>

</body>
</html>