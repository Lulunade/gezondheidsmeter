<?php 
session_start();

// if user is admin else go to login
if($_SESSION['admin'] != 1){
    header('Location: login');
}

// get db and sql classes
require ('classes/db.php');
require ('classes/sql.php');
$database = new Dbconfig();
$db = $database->getConnection();
$sqlQuery = new Sql($db);

// get all the current categories
$data = $sqlQuery->GetAdminQUestions();
$Categorieen = 0;
$Vragen = 0;
$Wegingen = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("layouts/head.php")?>
</head>
<body>
    <?php include_once("layouts/navbar.php")?>

    <br>
    <div class="container border border-dark">
        <div class="row">
            <h1>Vragenlijst</h1>
            <div class="col-md-8">
                <div class="row">
                    <form id="saveData" method="post" class=".form-inline .form-horizontal">
                        <!-- for every category create this html + add one to categories -->
                        <?php  while ($row = $data->fetch()) { $Categorieen++ ?>
                            <div class="form-group row mb-4">
                                <div class="col-8">
                                    <!-- name of cat -->
                                    <h2><?=$row['naam']?> </h2>
                                </div>
                                <div class="col-sm-4">
                                    <h3>Weging</h3>
                                </div>
                               <?php 
                            //    get all questions for this cat
                               $questiondata = $sqlQuery->GetAdminQuestion($row['ID']);
                               while($datarow = $questiondata->fetch()){
                                //    get id for later
                                    $Vragen = $datarow['VID'];
                                    // if there is a vaid add it 
                                    if($datarow['VAID'] !== null){
                                        $Wegingen = $datarow['VAID'];
                                    }
                                ?>
                                <!-- place dat -->
                                <div class="col-7 mb-3">
                                    <input type="text" name="<?=$row['ID'];?>Vraag<?=$datarow['VID'];?>" value="<?=$datarow['Vraag'];?>" class="form-control" id="Email" required>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <input type="number" name="<?=$row['ID'];?>Weging<?= $datarow['VID']?>" class="form-control" step=".01" placeholder="Weging" id="Email" value="<?=$datarow['Weging'];?>" required>
                                </div>
                                <?php } ?>
                                <!-- add button to add more of that categorie  -->
                                <div class="col-sm-1 mb-3" id="ContainerButton<?=$row['ID'];?>">
                                    <a onclick="addQuestion('<?=$row['ID'];?>')">
                                        <img src="images/32px-Plus_font_awesome.svg.png" height="100%" alt="Voeg vraag toe">
                                    </a>
                                </div>
                            </div>
                            <!-- end of forloop categories -->
                        <?php } ?>
                        <div class="form-group row mb-4">
                            <div class="col-4">
                            </div>
                            <div class="col-sm-8">
                                <!-- get highest id of questions to know when to update and when to insert -->
                                <input type="number" name="Amount" id="InpAmount" style="display:none;" value="<?=$Vragen?>">
                                <!-- save button -->
                                <input type="submit" id="saveData" name="saveData" value="Opslaan"
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
    <script>
        // get questions to js
            Vragen = <?= $Vragen;?>;
            weging = <?= $Wegingen;?>;
        // categorie add new question to cat
        function addQuestion(id) {
            Vragen++;
            weging++;
            console.log(Vragen);
            $( `<div class="col-7 mb-3"> <input type="text" name="`+id+`Vraag`+ Vragen +`" value="" class="form-control" id="Email" required=""> </div>
            <div class="col-sm-4 mb-3"><input type="number" name="`+id+`Weging`+ weging + `" class="form-control" placeholder="Weging" step=".01" id="Email" value="" required></div>
            ` ).insertBefore( "#ContainerButton"+ id );
        }
        // when form gets submited
        $("#saveData").submit(function(e) {
                               // stops from acutlly posting the post so we can use ajax insted
                               e.preventDefault(); 

                               var form = $(this);
                                  // posts a ajax call to form.php
                               $.ajax({
                                   type: "POST",
                                   url: "adminadd.php",
                                   data: form.serialize(), // serializes the form's elements.
                                   //  when it is a sucsess so this with the data it got back
                                   success: function(data)
                                   {
                                        console.log(Vragen);
                                        // higher the questions value so next form knows when to update and when to insert
                                        document.getElementById("InpAmount").value = Vragen;
                                        // show alert of sucsess
                                        adminsucsess();
                                   }
                               });
                            });
    </script>
    <?php include_once("layouts/footer.php")?>

</body>
</html>