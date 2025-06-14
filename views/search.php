<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Busqueda de lo que requieras cocinar">
    <link rel="icon" type="image/png" sizes="96x96" href="/makefs/views/favicon/makefslogo.png">
    <script src="/makefs/views/js/defineUrl.js"></script>
    <link href="/makefs/views/css/normalize.css" rel="stylesheet">
    <link href="/makefs/views/css/chefinx.css" rel="stylesheet">
    <link href="/makefs/views/css/header.css" rel="stylesheet">
    <link href="/makefs/views/css/DarkModeSe.css" rel="stylesheet">
    <link href="/makefs/views/css/DarkMenu.css" rel="stylesheet">
    <link rel="stylesheet" href="/makefs/views/css/footer.css">
    <link rel="stylesheet" href="/makefs/views/css/Preloader.css">

    
    <?php
        include("models/conexion.php");
        include("views/components/test_inputs.php");
        session_start();
        if(empty($_GET["search"]) && !isset($_GET["search"])){
            header("location: ./error.html");
        }
        if($_GET["search"]==""){
            header("location: ./index.php");
        }

        $txtBusqueda = $_GET["search"];
        $busqueda = explode(" ",$txtBusqueda);
        $busquedatxt = "";
        for ($i=0; $i < sizeof($busqueda) ; $i++) {
            if(sizeof($busqueda)-1 == $i){
                $busquedatxt .= $busqueda[$i];
            }else{
                $busquedatxt .= $busqueda[$i].' & ' ;
            }
        }
        
        $conn = new Conexion;
        $conn = $conn->Conectar();
        $consulta = "SELECT * FROM recipe INNER JOIN userm ON recipe.chefid= userm.chefid
         WHERE recipe_with_weights @@ to_tsquery('$busquedatxt:*') AND recipe.privater = false
        ORDER BY ts_rank(recipe_with_weights, to_tsquery('$busquedatxt:*')) desc, views desc limit 15";

        try{
            $recetas = $conn->prepare($consulta);
            $recetas->execute();
        }catch(Exception $e){
            echo "Fallo al traer las recetas".$e;
        }

        $recetas = $recetas->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <title>Makefs: <?php echo $txtBusqueda ?></title>
</head>
<body class="White">
    <?php
        include('views/components/header.php');
        include('views/components/menudesplegable.php');
        include('views/components/preloader.php');
    ?>
    <section class="recipe-container" id="principal-recipes">
        <div class="makefsContainer recipe-body">
            <h2 id="title-ctc">Resultados: <?php echo $txtBusqueda; ?></h2>
            <div class="general-recipes-container">
                <?php
               
                     for ($i=0; $i < sizeof($recetas) ; $i++){
                        $recipeid = $recetas[$i]['recipeid'];
                        $views = $recetas[$i]['views'];
                        $imagen = $recetas[$i]['imagen'];
                        $minpic = $recetas[$i]['minpic'];
                        $chefid = $recetas[$i]['chefid'];
                        $recetaname = test_input($recetas[$i]['namer']);
                        $username = test_input($recetas[$i]['username']);

                        $query = "SELECT AVG(star) FROM stars WHERE recipeid =$recipeid";
                        try{
                            $average = $conn->prepare($query);
                            $average->execute();
                            $average = $average->fetchColumn();
                            if (empty($average)){
                                $average = "0";
                            }
                            if(sizeof(explode(".",$average)) == 1){
                                $average = $average.".0";
                            }
                        }catch(Exception $e){
                            print_r($e);
                            exit;
                        }
                        $average = number_format($average,1);
                        echo <<< EOT
                        <div class="recipe-template">
                            <a class="image-template" href="./ddr.php?video=$recipeid" target="__blank">
                                <img src="/makefs/mediaDB/recipeImages/$imagen" alt="imagen de receta">
                                <figure class="star-template WhiteStar"><img src="/makefs/views/img/hico-star-red.png" alt="estrellas"><b id="starCount">$average</b></figure>
                            </a>
                            <div class="next-text-recipe Whiterecipe">
                                <img src="/makefs/mediaDB/usersImg/$minpic" alt="imagen de usuario">
                                <div>
                                    <a href="/makefs/recipe/$recipeid"><h3 class="text-template">$recetaname</h3></a>
                                    <a href="/makefs/chef/$chefid" target="__blank">
                                        <p>$username</p>
                                        <p>$views Views</p>
                                    </a>
                                </div>
                            </div>
                            </a>
                            
                        </div>
                        EOT;
                        $recipe = true;
                     }
                     if(empty($dataAll["recipeid"]) && empty($recipe)){
                        echo <<<EOT
                            <div id="notFoundRecipes" class="Whitecookie">
                                <img src="/makefs/views/img/notrecipesSearch.png" alt="cookie">
                                <h3>No se han encontrado recetas con tu búsqueda.</h3>
                            </div>
                        EOT;
                    }
                    include('views/components/categoriesMenu.php');
                ?>
            </div>
        </div>
    </section>
    <?php
        include('views/components/footer.php');
    ?>
    <script src="/makefs/views/js/index.js"></script>
    <script src="/makefs/views/js/menuDesplegable.js"></script>
    <script src="/makefs/views/js/DarkModeSe.js"></script>
    <script src="/makefs/views/js/DarkLoader.js"></script>
    <script src="/makefs/views/js/preloader.js"></script>
    <script src="/makefs/views/js/DarkModeM.js"></script>
    <script src="/makefs/views/js/responsiveCategoriesOutIndex.js"></script>
</body>
</html>