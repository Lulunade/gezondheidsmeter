<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("layouts/head.php")?>
</head>
<body>
    <?php include_once("layouts/navbar.php")?>
    <div class="container mw-100">
        <ul class="carousel-indicators">
            <li data-target="#slides" data-slide-to="0" class="active"></li>
            <li data-target="#slides" data-slide-to="1"></li>
        </ul>
        <div class="carousel-inner">
            <div id="welcome" class="carousel-item active">
                <img class="w-100 pt-2 " style="height: 22em; object-fit:cover;" src="Images/136934.jpg">
                <div class="carousel-caption">
                    <h1 class="display-2 d-none d-sm-block"></h1>
                    <h1 class="d-none d-sm-block"></h1>
                    <p class="d-sm-none mb-0" style="font-size: 20px;"></p>
                    <p class="d-sm-none mb-0" style="font-size: 20px;"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-5 pb-5">
        <h1 class="display-3 text-center">Gezondheid</h1>
        <div class="container-fluid">
            <div class="row">
                <div class="row mt-5">
                <p class="col-10 offset-1 h2 lh-base">
                    Bij de gezondheidsmeter kunt u elke dag invullen met wat u heeft gedaan. Met de informatie dat u
                    doorgeeft kunnen wij een dashboard maken met hoe gezond u leefstyle is. U kunt ook zien per onderdeel
                    wat u er aan zou kunnen verbeteren. U kunt beginnen door <a href="register.php">hier</a>
                    een account aan te maken met de benodigde informatie.
                </p>
                </div>
                <p class="text-info d-md-none"></p>
                <p class="text-info d-md-none"></p>
            </div>
        </div>
    </div>
    <?php include_once("layouts/footer.php")?>

</body>
</html>