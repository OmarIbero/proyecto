<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="96x96" href="/makefs/views/favicon/makefslogo.png">
    <link href="/makefs/views/css/normalize.css" rel="stylesheet">
    <link href="/makefs/views/css/chefinx.css" rel="stylesheet">
    <link href="/makefs/views/css/report.css" rel="stylesheet">
    <link href="/makefs/views/css/header.css" rel="stylesheet">
    <link href="/makefs/views/css/footer.css" rel="stylesheet">
    <link href="/makefs/views/css/ddr.css" rel="stylesheet">
    <link href="/makefs/views/css/notifications.css" rel="stylesheet">
    <link href="/makefs/views/css/libraryNotif.css" rel="stylesheet">
    <link href="/makefs/views/css/not-registered.css" rel="stylesheet">
    <link href="/makefs/views/css/Darkddr.css" rel="stylesheet">
    <link href="/makefs/views/css/DarkMenu.css" rel="stylesheet">
    <meta name="description" content="Mira la preparacion de tu receta que deseas aprender y aprende a cocinar">
    <meta name="robots" content="index, follow">
    <script src="/makefs/views/js/defineUrl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let recipeProperties = {
            reported: false,
            rate: 0.0,
            savedrecipes: 0
        }
    </script>
    <?php
    include("models/conexion.php");
    include("views/components/test_inputs.php");
    session_start();

    ?>
</head>
<body class="White">
    <?php
    include('views/components/header.php');
    include('views/components/menudesplegable.php');
    include("views/components/report.php");
    ?>
    <div class="makefs-notification ddr-in-notification">
        <figure class="makefs-notification-rep"></figure>
        <article class="makefs-notification-info"><b class="notification-title">Notificación</b><p id="notification-msg">En espera</p></article>
    </div>
    <div class="bookshelf-notification WhiteNotif">
        <img id="bookshelf-icon" src="/makefs/views/iconos/book.png" alt="guardados">
        <article class="makefs-notification-info"><b class="notification-title">Notificación</b><p id="notification-save-msg">bookshelf Notification</p></article>
        <a target="_blank" href="/makefs/library/<?php echo $_SESSION["id"]?>">Ir a biblioteca</a>
    </div>
    <section id="recipe_section">
        <div class="recipe_container">
            <div class="makefs-media-player">
                <button id="first-play-btn"></button>
                <video id="source_video" poster="https://cloudfront-us-east-1.images.arcpublishing.com/infobae/6OONK4H3QFCT5KZNGMPHEV2KEY.jpg ">
                    <source src="../controllers/video_streaming/startStream.php?video=<?php echo '';?>" type="video/mp4"/>
                    <source src="../controllers/video_streaming/startStream.php?video=<?php echo '';?>" type="video/webm"/>
                    El navegador no soporta este formato de video
                </video>
                <div class="loading-obj"></div>
                <div class="in-panel-video" id="mkfv_controlls_big_panel">
                    <figure class="makefs-video-in-panel-video" id="mkfv_controlls_backTo"></figure>
                    <figure class="makefs-video-in-panel-video" id="mkfv_controlls_big_play"></figure>
                    <figure class="makefs-video-in-panel-video" id="mkfv_controlls_afterTo"></figure>
                </div>
                <button id="makefs-steps-info-button"></button>
                <div class="step-anotation" ocNotif="1">
                    <button id="step-annotation-close">x</button>
                    <h2 id="step-annotation-number">1</h2>
                    <article>
                        <b id="step-annotation-minutes">00:00 - 00:00</b>
                        <p id="step-annotation-detail">Video Notification / Step not setted yet</p>
                    </article>
                    <button id="step-annotation-show-more" ocPanelEl="1">ver más</button>
                    <span id="step-annotation-show-more-gradient"></span>
                </div>
                <ul class="makefs-steps-info-container">
                    <h2>Pasos</h2>

                    <?php
                        $counter = 1;
                        foreach (['12', '13', '45'] as $key => $stepRenderInfo){
                            echo <<<EOT
                                <li class="makefs-steps-info-template" ocMinute="$stepRenderInfo[1]">
                                    <a class="makefs-steps-info-display-details">v</a>
                                    <h3>$counter</h3>
                                    <article>
                                        <h4> $stepRenderInfo[1] - $stepRenderInfo[2]</h4>
                            EOT;
                                    echo "<p>".test_input($stepRenderInfo[0])."</p>";
                                echo "</article>
                                </li>";
                            $counter++;
                        }

                    ?>
                </ul>
                <div></div>
                <span id="progress-bar-time-read">00:00</span>
                <div class="makefs-video-controls controls-hidden first-play">
                    <div class="makefs-video-progress">
                        <progress id="mkfs_video_progress_bar" min="0">
                        </progress>
                        <figure class="mkfs_video_dragable_ball" draggable="true"></figure>
                        <figure class="mkfs_video_dragable_representation mkfs_ball_static"></figure>
                    </div>
                    <div class="first-controls">
                        <button id="mkfv_controlls_play" class="makefs-video-control-button"></button>
                        <button id="mkfv_controlls_mute" class="makefs-video-control-button"></button>
                        <div class="volume-containers">
                            <input type="range" name="volume-range" id="mkfv_controlls_volume_rep" min="0" max="1" step="0.05">
                            <input type="range" name="volume-range" id="mkfv_controlls_volume" min="0" max="1" step="0.05">
                        </div>
                    </div>
                    <div class="last-controls">
                        <p id="time_counter">00:00-00:00</p>
                        <div class="config-options">
                            <div class="makefs-video-config-menu main-config-options">
                                <button id="makefs-video-controls-steps"><p>Pasos</p><figure class="config-controllers-slidable"><span class="slidable-switch" id="config-controllers-slidable-steps"></span></figure></button>
                                <button id="makefs-video-controls-bucle"><p>Bucle</p><figure class="config-controllers-slidable"><span class="slidable-switch" id="config-controllers-slidable-bucle"></span></figure></button>
                                <button id="makefs-video-controls-speedrate"><p>Velocidad de reproduccion</p><p id="actual-speed-rate">Normal</p></button>
                            </div>
                            <div class="makefs-video-config-menu" id="speedrate-options">
                                <button id="makefs-video-controls-speedrate-back">Volver</button>
                                <button class="makefs-video-controls-speedrate" setRate="0.25">0.25</button>
                                <button class="makefs-video-controls-speedrate" setRate="0.50">0.50</button>
                                <button class="makefs-video-controls-speedrate" setRate="0.75">0.75</button>
                                <button class="makefs-video-controls-speedrate" setRate="1">Normal</button>
                                <button class="makefs-video-controls-speedrate" setRate="1.25">1.25</button>
                                <button class="makefs-video-controls-speedrate" setRate="1.50">1.50</button>
                                <button class="makefs-video-controls-speedrate" setRate="1.75">1.75</button>
                                <button class="makefs-video-controls-speedrate" setRate="2">2</button>
                            </div>
                        </div>
                        <button id="mkfv_controlls_config" class="makefs-video-control-button"></button>
                        <button id="mkfv_controlls_fullscreen" class="makefs-video-control-button"></button>
                    </div>
                </div>
            </div>
            <div class="ddr-bottom-panels">
                <div class="makefs-video-info-panels">
                    <h1 class="makefs-video-info-title Whitetitlevideo"><?php echo 'Arepa quesuda'?></h1>
                    <a class="makefs-video-info-chef" href="/makefs/chef/<?php echo 'Omar'; ?>">
                        <div id="foto-chef-ddr">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUc1r2L0Ej6n2fhtZU87FxW2-jKXcUbSctxQ&s " alt="">
                        </div>
                        
                        <article>
                            <p id="usernameSection" class="Whiteusername"> <?php echo  '' ?></p>
                            <p class="seguidoresp whitepseg"> <b id="followersSection" class="Whitefollow"><?php echo 200 ?></b> Seguidores</p>
                            <?php
                                if($_SESSION['id']==0){
                                    echo <<<EOT
                                        <button id='followUnloged'>seguir</button>
                                        <div id='unlogedFollowSect'>
                                        <button id="close-UnlogedFollow"></button>
                                            <div id='unlogedFollowDiv'>
                                                <h4>Para seguir a un usuario debes estar logueado!</h4>
                                                <button id="logRedirect">LogIn</button>
                                            </div>
                                        </div>
                                    EOT;
                                }else{
                                    if(isset($followid)){
                                        echo "<button id='follow-button'>siguiendo</button>";
                                    }else{
                                        echo "<button id='follow-button'>seguir</button>";
                                    }
                                }
                            ?>  
                        </article>
                        </a>
                    <div class="makefs-video-interactions">
                        <p class="viewp Whiteviewp"><b id="makefs-video-views" class="Whiteview" ><?php echo '' ?></b> Visualizaciones</p>
                        <div class="makes-recipe-tags-wrapper">
                            <?php
                                $region = "Peru";
                                foreach (["Comida", "Peruana"] as $key => $value){
                                    echo "<p class='makefs-recipe-tag'>".test_input($value)."</p>";
                                }
                            ?>
                        </div>
                        <div class="makefs-video-report-save">
                            <button id="save-actual-recipe">Guardar</button>
                            <button id="report-actual-recipe">Reportar</button>
                        </div>
                        <?php 
                            if ($_SESSION["id"] == 0) {
                                echo <<<EOT
                                <div class="not-registered-advise">
                                    <img src="/makefs/views/iconos/makefslogo.jpg" alt='makefslogo'>
                                    <button id="hide-not-register-notif">x</button>
                                    <article>
                                        <p>Para poder interactuar con este video debes estar registrado</p>
                                        <a href="/makefs/register">¡Registrate!</a>
                                    </article>
                                </div>
                                EOT;
                            }
                        ?>
                        <ul class="makefs-video-star-valoration">
                            <span class="loading-rate-action"></span>
                            <li class="makefs-selection-star-container">
                                <button starValue="0.5"></button>
                                <button starValue="1.0"></button>
                            </li>
                            <li class="makefs-selection-star-container">
                                <button starValue="1.5"></button>
                                <button starValue="2.0"></button>
                            </li>
                            <li class="makefs-selection-star-container">
                                <button starValue="2.5"></button>
                                <button starValue="3.0"></button>
                            </li>
                            <li class="makefs-selection-star-container">
                                <button starValue="3.5"></button>
                                <button starValue="4.0"></button>
                            </li>
                            <li class="makefs-selection-star-container">
                                <button starValue="4.5"></button>
                                <button starValue="5.0"></button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="makefs-recommended-panels">
                    <div class="in-recipe-recommended-container">
                        <h3 class="recomended-title">recomendados</h3>
                        <?php 
                            $title = "Arepa quesuda ";
                            $chefname = "la abuelita de colombia";
                            echo <<<EOT
                                <div class="recipe-template ddr-recipe">
                                    <a class="image-template" href="/makefs/recipe/123">
                                        <figure class="star-template WhiteStar"><img src="/makefs/views/img/hico-star-red.png" alt='estrellas de receta'><b id="starCount">5.0</b></figure>
                                    </a>
                                   
                                </div>
                            EOT;
                        ?>
                    </div>
                    <div class="makefs-video-ingredients-ad-wrapper">
                        <h3 class="makefs-ingredients-tittle">Ingredientes</h3>
                        <ul class="makefs-ingredients-wrapper">
                        <?php
                            $ingredientsBase64 = base64_decode('');
                            $ingredientsDecoded = json_decode($ingredientsBase64,true);
                            foreach (["Pollo", "Arroz"] as $key => $value){
                                echo "<p class='makefs-ingredient'>".test_input($value)."</p>";
                            }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
                <?php
                    include('views/components/categoriesMenu.php');
                ?>
        </div>
    </section>
    <?php
        include('views/components/footer.php');
        if($_SESSION['id']!=0){
            echo <<<EOT
                <script src='/makefs/views/js/axiosFollow.js'></script>
                <script src="/makefs/views/js/axiosReport.js"></script>
                <script src="/makefs/views/js/axiosSaveRecipe.js"></script>
            EOT;
        }
    ?>
    <script src="/makefs/views/js/index.js"></script>
    <script src="/makefs/views/js/ddr.js"></script>
    <script src="/makefs/views/js/followUnloged.js"></script>
    <script src="/makefs/views/js/report.js"></script>
    <script src="/makefs/views/js/menuDesplegable.js"></script>
    <script src="/makefs/views/js/DarkModeddr.js"></script>
    <script src="/makefs/views/js/DarkLoader.js"></script>
    <script src="/makefs/views/js/DarkModeM.js"></script>
    <script src="/makefs/views/js/responsiveCategoriesOutIndex.js"></script>
</body>

</html>