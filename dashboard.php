<?php 
session_start();
if(empty($_SESSION['loggedIn'])){
    header('Location: login');
}

require ('classes/db.php');
require ('classes/sql.php');
$database = new Dbconfig();
$db = $database->getConnection();
$sqlQuery = new Sql($db);
$array = [];
$Categoriesarray = [];
$correctarray = [];
$data = $sqlQuery->getUserDashboardData($_SESSION['userID']);
$data2 = $sqlQuery->GetCategories();

while($row = $data2->fetch()){
    array_push($Categoriesarray, $row);
}
while($row = $data->fetch()){
    array_push($array, $row);
}

$colors = array_count_values(array_column($array, 2));

foreach ($colors as $key => $item) { 
    $correctarray[$key] = array();  
}   

foreach($array  as $key => $item){
    array_push($correctarray[$item["Categorie_ID"]], $item);
}

//var_dump(json_encode($colors));


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.3.0/snap.svg-min.js"></script>
    <?php include_once("layouts/head.php")?>
    <style>
    #arrow {
        transform: translate(192px,106px) rotate(0deg);
        transform-origin: 12px 93px;
    }
</style>
<script>
      function changeradius(avarage, progress, circle1) {
        console.log(avarage);
        var procent = (avarage / 2 * 100 );
        var val = procent / 100 * 251.2;
        console.log(procent);
        progress.attr({ 'stroke-dasharray':val + ',251.2'});
        switch (true) {
        case (procent <= 25):
            circle1.setAttribute("stroke","red");
            break;
        case (procent <= 50):
            circle1.setAttribute("stroke","orange");
            break;
        case (procent <= 75):
            circle1.setAttribute("stroke","lightgreen");
            break;
        case (procent <= 100):
            circle1.setAttribute("stroke","green");
            break;
        default:
            circle1.setAttribute("stroke","blue");
            break;
    }
    }
</script>
</head>
<body>
    <?php include_once("layouts/navbar.php")?>

    <div class="container">
        <div class="row">
            <div class="text-center">
                <svg width="400" height="200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="none" stroke="green" stroke-width="100" d="M 300 200 A 100 100 0 0 0 270.71067811865476 129.28932188134524"></path>
                    <path fill="none" stroke="red" stroke-width="100" d="M 129.28932188134524 129.28932188134524 A 100 100 0 0 0 100 200"></path>
                    <path fill="none" stroke="#ffec04" stroke-width="100" d="M 200 100 A 100 100 0 0 0 129.28932188134524 129.28932188134524"></path>
                    <path fill="none" stroke="#b0cc0c" stroke-width="100" d="M 270.71067811865476 129.28932188134524 A 100 100 0 0 0 200 100"></path>
                    <g id="arrow">
	                    <path fill="#464646" d="M13.886,84.243L2.83,83.875c0,0,3.648-70.77,3.956-74.981C7.104,4.562,7.832,0,8.528,0
	                    	c0.695,0,1.752,4.268,2.053,8.894C10.883,13.521,13.886,84.243,13.886,84.243z"/>
	                    <path fill="#464646" d="M16.721,85.475c0,4.615-3.743,8.359-8.36,8.359S0,90.09,0,85.475c0-4.62,3.743-8.363,8.36-8.363
	                    	S16.721,80.855,16.721,85.475z"/>
	                    <circle fill="#EEEEEE" cx="8.426" cy="85.471" r="2.691"/>
	                </g>
                </svg>
                <svg id="meter_needle" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                	 width="16.721px" height="93.834px" viewBox="0 0 16.721 93.834" enable-background="new 0 0 16.721 93.834" xml:space="preserve">

                </svg>
            </div>
        </div>
        <div class="row" id="tipsID">
            <div class="col-md-5 mx-auto">
                <h5 class="text-center mt-4">Tip</h5>
                <div class="border border-dark p-2">
                    <?php
                        if(!empty($correctarray)) {
                            echo "<script>document.getElementById('tipsID').style.display = 'block'</script>";
                            foreach ($correctarray as $item) {
                                $category = $item[0]['naam'];
                                $total = 0;
                                $x = 0;
                                foreach ($item as $value) {
                                    $total = $total + $value['Score'];
                                    $x++;
                                }
                                $average = $total / $x;

                                switch (true) {
                                    case ($average <= 0.5):
                                        echo "<p><b>${category}</b>: moet enorm verbeterd worden.</p>";
                                        break;
                                    case ($average > 0.5 && $average <= 1.0):
                                        echo "<p><b>${category}</b>: moet redelijk verbeterd worden.</p>";
                                        break;
                                    case ($average > 1.0 && $average <= 1.5):
                                        echo "<p><b>${category}</b>: moet een stukje beter</p>";
                                        break;
//                                case ($average > 1.5 && $average <= 2.0):
//                                    echo "Groen";
                                }
                            }
                        } else {
                            echo "<script>document.getElementById('tipsID').style.display = 'none'</script>";
                        }
                    ?>
                </div>
            </div>
        </div>
        
    </div>
    <div class="container">
        <div class="row">
    <?php
        $i=0;
        $allCategoryNames = array_column($Categoriesarray, 'naam');

            foreach ($correctarray as $key => $item){
                $count = 0;
                foreach ($item as $key => $inneritem){
                    $count = $count + doubleval($inneritem['Score']);
                    $allCategoryNames = array_diff($allCategoryNames, [$inneritem['naam']]);
                }
                $count = $count / count($item);

                echo '<div class="col-md-4"><svg class="animated ml-auto mr-auto d-block" id="animated'. $i .'" viewbox="0 0 100 100"><circle cx="50" cy="50" r="35" fill="#002A5C"/><path id="progress'. $i .'" stroke-linecap="round" stroke-width="5" stroke="#EA5221" fill="none"      d="M50 10         a 40 40 0 0 1 0 80         a 40 40 0 0 1 0 -80"></path><text id="count" x="50" y="50" fill="white" text-anchor="middle" dy="7" font-size="20">'. round($count / 2 * 100) .'%</text></svg> <p class="text-center">' .  $item[0]['naam'] . '</p> </div>';
                echo "
                <script>
                    var s = Snap('#animated".$i."');
                    var progress = s.select('#progress".$i."');
                    var circle1 = document.getElementById('progress".$i."');
                    changeradius('". $count ."', progress, circle1);
                </script>
                ";
                $i++;
            }
            foreach ($allCategoryNames as $categoryName) {
                echo '<div class="col-md-4"><svg class="animated ml-auto mr-auto d-block" id="animated'. $i .'" viewbox="0 0 100 100"><circle cx="50" cy="50" r="35" fill="#002A5C"/><path id="progress'. $i .'" stroke-linecap="round" stroke-width="5" stroke="green" fill="none"      d="M50 10         a 40 40 0 0 1 0 80         a 40 40 0 0 1 0 -80"></path><text id="count" x="50" y="50" fill="white" text-anchor="middle" dy="7" font-size="20">100%</text></svg> <p class="text-center">' .  $categoryName .  '</p> </div>';
            }

        ?>
        </div>
        <div class="row">
            <h3 class="mt-4">Nieuwe vragenlijst invullen</h3>
            <div class="VragenlijstButton">
                <a href="vragenlijst.php" style="color: white; text-decoration: none;"><p>Ga naar de vragenlijst</p></a>
            </div>
        </div>
    </div>
    <?php include_once("layouts/footer.php")?>
    <script>
    var array = [<?php foreach ($array as &$value) { echo $value['Score'];?>, <?php }?>];
    var n = array.length;
    var avarage = average(array, n);
    document.getElementById("arrow").style.transform = "translate(192px,106px) rotate("+(2 * pointDirection(avarage))+"deg)";

    function anyRandomNumber(min, max){
        let r = Math.random();
        r*=(max-min);
        r+=min;
        console.log(Math.floor(r));
        return Math.floor(r);
    }
    function pointDirection(x){
        return Math.atan2(x - 1, 1) * 180 / Math.PI;
    }
    function average(a, n) {

        // Find sum of array element
        var sum = 0;
        for (var i = 0; i < n; i++) {
            sum += a[i];
        }

        return parseFloat(sum / n);
    }

</script>
</body>
</html>