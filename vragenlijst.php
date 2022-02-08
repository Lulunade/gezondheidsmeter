<?php
require_once ('classes/db.php');
require_once ('classes/sql.php');
require_once ('classes/vragen.php');

session_start();
if(empty($_SESSION['loggedIn'])){
    header('Location: login.php');
}

$database = new Dbconfig();
$db = $database->getConnection();
$sqlQuery = new Sql($db);

$vragen = new Vragen();
$categories = $sqlQuery->GetCategories();

$values = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    foreach ($_POST as $id=>$value)
    {
        if ($value != "Submit Query")
        {
            $sqlQuery->InsertQuestions($id, $_SESSION['userID'], $value);
            header('Location: dashboard.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="css/vragenlijst.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.js"></script>
    <?php include_once("layouts/head.php")?>
</head>
<body>
    <?php include_once("layouts/navbar.php")?>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <p class="h2 page-title">Vragenlijst</p>
                <p class="page-description">Er komen elke dag nieuwe vragen over uw activiteiten.
                    We gaan deze informatie analyseren zodat we een beeld
                    kunnen schetsen over uw gezondheid.
                </p>
            </div>
            <div class="col-sm"></div>
            <hr/>
        </div>
        <div class="row">
            <form class="questionContainer form-group" action="" method="post">
            <?php
                while ($row = $categories->fetch()) {
                    $data = $sqlQuery->getQuestions($row['ID']);
                    echo "<div class=category><br><p class='h4'>Categorie: {$row['naam']}</p>";
                    while ($row = $data->fetch()) {
                        $vragen->id = $row['ID'];
                        $vragen->title = $row['Vraag'];
                        if ($row['type'] == 'number') {
                            echo $vragen->Number();
                        } else if ($row['type'] == 'multiple') {
                            $vragen->id = $row['ID'];
                            echo $vragen->MultipleChoice();
                        } else if ($row['type'] == 'checklist') {
                            $vragen->id = $row['ID'];
                            echo $vragen->CheckList();
                        }
                    }
                    echo "</div>"
                    ?>
                    <?php
                }
            ?>
                <div class="category" style="margin-left: 10px">
                    <p><b>De vragenlijst is ingevuld! Klik hieronder om de resultaten te verzenden</b></p>
                    <input type="submit" name="submit" value="Verzend vragenlijst" class="btn pagebutton">
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-sm" style="margin: 10px 0px 10px 10px">
                <button type="button" class="btn pagebutton" onclick="back()" id="previousBtn" disabled>Vorige</button>
                <button type="button" class="btn pagebutton" onclick="next()" id="nextBtn">Volgende</button>

            </div>
        </div>
    </div>


    <?php include_once("layouts/footer.php")?>
    <script>
        let current = 0;
        let elements = document.getElementsByClassName('category');
        let max = elements.length

        function next() {

            elements[current].style.display = 'none';
            current++
            if (elements[current] != null) {
                elements[current].style.display = 'block';
            }
            if (current === elements.length - 1) 
            {
                document.getElementById("nextBtn").disabled = true;
                
            }

            if (current > 0)
            {
                document.getElementById("previousBtn").disabled = false;
            }
        }
        function back() {
            if (current != 0) {
                elements[current].style.display = 'none';
                current--
                elements[current].style.display = 'block';
            }
            console.log(elements.length)
            console.log(current)

            if (current < (elements.length - 1)) 
            {
                document.getElementById("nextBtn").disabled = false;
                
            }

            if (current < 1)
            {
                document.getElementById("previousBtn").disabled = true;
            }
        }
    </script>
</body>
</html>