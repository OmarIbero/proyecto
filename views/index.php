<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" sizes="96x96" href="views/favicon/makefslogo.png">
        <link href="views/css/normalize.css" rel="stylesheet">
        <link href="views/css/chefinx.css" rel="stylesheet">
        <link href="views/css/header.css" rel="stylesheet">
        <link href="views/css/DarkModeIndex.css" rel="stylesheet">
        <script src="views/js/defineUrl.js"></script>
        <link rel="stylesheet" href="views/css/footer.css">
        <link rel="stylesheet" href="views/css/DarkMenu.css">
        <link rel="stylesheet" href="views/css/Preloader.css">
        <meta name="description" content="Encuentra las mejores recetas de comida con la forma más sencilla de verlas!">
        <meta name="robots" content="index, follow">

        <title>Inicio Makef's</title>
    <?php
        session_start();
        if (true || $_SESSION["id"] == 0){
            include_once("models/conexion.php");
            $rConn = new Conexion();
            try {
                $rConn = $rConn->Conectar();
                $rConn->beginTransaction();

                $query = "SELECT 
                recipe.recipeid, recipe.chefid,recipe.namer, recipe.status,recipe.imagen, recipe.duration, recipe.tags, recipe.region, recipe.views,recipe.privater, recipe.chefname,
                CAST(AVG(stars.star) AS DECIMAL(10,2)) AS rate,
                userm.minpic
                FROM recipe INNER JOIN userm ON userm.chefid = recipe.chefid INNER JOIN stars ON stars.recipeid = recipe.recipeid 
                WHERE recipe.privater = FALSE GROUP BY (recipe.recipeid, recipe.chefid,recipe.namer, recipe.status,recipe.imagen, recipe.duration, recipe.tags, recipe.region, recipe.views,recipe.privater, recipe.chefname, userm.minpic) LIMIT 20";
                $exec = $rConn->prepare($query);
                $exec->execute();
                $exec = $exec->fetchAll(PDO::FETCH_ASSOC);
                
                $finalOrdering = array();

                function ordering($rate,$views){
                    $viewRanges = [
                        [0,20],
                        [20,50],
                        [50,100],
                        [100,500],
                        [500,1000],
                        [1000,10000],
                        [10000, 20000],
                        [20000, 50000],
                        [50000, 100000],
                        [100000,1000000]
                    ];
                    $vscore = 0;
                    $vrate = 0;
                    for($i = 0; $i < sizeof($viewRanges); $i++){
                        if ($viewRanges[$i][0] <= $views && $viewRanges[$i][1] >= $views){
                            $vscore = ($i+1) * 100;
                            break;
                        }
                    }
                    try{
                        $vrate = (number_format($rate,2) / 0.5) * 100;
                    }catch (DivisionByZeroError $e){
                        $vrate = 100;
                    }
                    return $vrate + $vscore;
                }

                foreach ($exec as $key => $val){
                    array_push($finalOrdering,[
                        "recipeid"=>$val["recipeid"],
                        "chefid"=>$val["chefid"],
                        "namer"=>$val["namer"],
                        "rate"=>$val["rate"],
                        "views"=>$val["views"],
                        "chefname"=>$val["chefname"],
                        "imagen"=>$val["imagen"],
                        "chefpic"=>$val["minpic"],
                        "fscore"=> ordering($val["rate"], $val["views"])
                    ]);
                }

                usort($finalOrdering, function ($item1, $item2) {
                    return $item2['fscore'] <=> $item1['fscore'];
                });
                $response = json_decode(json_encode(["recipes"=>$finalOrdering]));
            } catch (Exception $e) {
                print_r($e);
                $rConn->rollBack();
            }
        }else{
            include("views/components/tokenControl.php");
            $url = "https://makefsapi.herokuapp.com/user/$_SESSION[id]/vr";

            $ch = curl_init($url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

            $viewed = curl_exec($ch);
            curl_close($ch);

            $rConn = new Conexion();
            $rConn = $rConn->Conectar();
            
            $viewed = false;
            
            $numsViewed = array_map('intval',$viewed);
            $numsViewed = implode(",",$numsViewed);

            if(empty($numsViewed)){
                $numsViewed = 0;
            }

            $selectQuery = "SELECT 
            recipe.recipeid, recipe.chefid,recipe.namer, recipe.status,recipe.imagen, recipe.duration, recipe.tags, recipe.region, recipe.views,recipe.privater, recipe.chefname,
            CAST(AVG(stars.star) AS DECIMAL(10,2)) AS rate,
            userm.minpic
            FROM recipe INNER JOIN userm ON userm.chefid = recipe.chefid INNER JOIN stars ON stars.recipeid = recipe.recipeid 
            WHERE recipe.recipeid NOT IN ($numsViewed) AND recipe.privater = FALSE GROUP BY (recipe.recipeid, recipe.chefid,recipe.namer, recipe.status,recipe.imagen, recipe.duration, recipe.tags, recipe.region, recipe.views,recipe.privater, recipe.chefname, userm.minpic) LIMIT 20";

            try {
                $getR = $rConn->prepare($selectQuery);
                $getR->execute();
                $res = $getR->fetchAll(PDO::FETCH_ASSOC);
                $data = json_encode($res);
                $url = "https://makefsapi.herokuapp.com/user/$_SESSION[id]";
    
                $ch = curl_init($url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch,CURLOPT_POST,true);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Content-type: application/json"
                ]);
    
                $response = json_decode(curl_exec($ch));
                curl_close($ch);
            } catch (Exception $th) {
                print_r($th);
            }
        }
        if(isset($_SESSION["errorRegister"])){
            unset($_SESSION["errorRegister"]);
        }

        if(isset($_SESSION["errorLog"])){
            unset($_SESSION["errorLog"]);
        }
    ?>
</head>
<body class="White">
    <?php
        include('views/components/header.php');
        include('views/components/menudesplegable.php');
        include('views/components/preloader.php');
    ?>
    <section class="recipe-container" id="principal-recipes">
        <div class="makefsContainer recipe-body">
            <?php 
                include("views/components/test_inputs.php");
                if (isset($_SESSION["id"]) && $_SESSION["id"] > 0){
                    $name = explode(" ",test_input($_SESSION["nombre"]))[0]; 
                    echo "<h2 id='title-ctc'>¡Hola $name! Tenemos Recomendaciones para ti</h2>";
                }else{
                    echo "<h2 id='title-ctc'>Lo mejor de Makefs</h2>";
                }
            ?>
            <div class="general-recipes-container">
                <?php 
                if(isset($response)){

                    foreach ($response->recipes as $key => $recipe) {
                        $recipe->rate = number_format($recipe->rate, 1);
                        $title = test_input($recipe->namer);
                        $chefname = test_input($recipe->chefname);
                        echo <<<EOT
                            <div class="recipe-template">
                                <a class="image-template" href="/makefs/recipe/$recipe->recipeid">
                                    <img src="mediaDB/recipeImages/$recipe->imagen" alt="imagen de receta">
                                    <figure class="star-template WhiteStar"><img src="views/img/hico-star-red.png" alt="estrellas"><b id="starCount">$recipe->rate</b></figure>
                                </a>
                                <div class="next-text-recipe WhiteModeP">
                                    <img src="mediaDB/usersImg/$recipe->chefpic" alt="imagen de usuario">
                                    <div>
                                        <a href="/makefs/recipe/$recipe->recipeid"><h3 class="text-template">$title</h3></a>
                                        <a href="/makefs/chef/$recipe->chefid">
                                            <p>$chefname</p>
                                            <p>$recipe->views Views</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        EOT;
                    }
                }

                echo <<<EOT
                            <div class="recipe-template">
                                <a class="image-template" href="/makefs/recipe/123">
                                    <img src="https://cloudfront-us-east-1.images.arcpublishing.com/infobae/6OONK4H3QFCT5KZNGMPHEV2KEY.jpg " alt="imagen de receta">
                                    <figure class="star-template WhiteStar"><img src="views/img/hico-star-red.png" alt="estrellas"><b id="starCount">4.2</b></figure>
                                </a>
                                <div class="next-text-recipe WhiteModeP">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUc1r2L0Ej6n2fhtZU87FxW2-jKXcUbSctxQ&s" alt="imagen de usuario">
                                    <div>
                                        <a href="/makefs/recipe/123"><h3 class="text-template">Arepa quesuda</h3></a>
                                        <a href="/makefs/chef/456">
                                            <p>La Abuelita de colombia</p>
                                            <p>200 Views</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        EOT;
                if(empty($recipe) && empty($recipe)){
                    echo <<<EOT
                        <div id="notFoundRecipes" class="Whitecookie">
                            <img src="views/img/notrecipesSearch.png" alt="cookie">
                            <h3>No hay videos disponibles. Sube uno!</h3>
                        </div>
                    EOT;
                }
                ?>
                <?php
                    include('views/components/categoriesMenu.php');
                ?>
            </div>
            
        </div>
    </section>
    <?php
        include('views/components/footer.php');
    ?>
    <script src="views/js/index.js"></script>
    <script src="views/js/darkModeIndex.js"></script>
    <script src="views/js/DarkLoader.js"></script>
    <script src="views/js/preloader.js"></script>
    <script src="views/js/menuDesplegable.js"></script>
    <script src="views/js/DarkModeM.js"></script>
    <script src="views/js/responsiveCategories.js"></script>
    </body>
</html>