<?php
    if(sizeof(explode("/",$_SERVER["REQUEST_URI"])) > 1 && sizeof(explode("/",$_SERVER["REQUEST_URI"])) < 3){
        $viewsUrl = "/makefs/views";
        $mediaUrl = "/makefs/mediaDb";
    }else if(sizeof(explode("/",$_SERVER["REQUEST_URI"])) > 2){
        $viewsUrl = "/makefs/views";
        $mediaUrl = "/makefs/mediaDb";
    }else{
        $viewsUrl = "views";
        $mediaUrl = "mediaDB";
    }

    $viewsUrl = "/makefs/views";
    $mediaUrl = "/makefs/mediaDB";
echo <<<EOT
    <section id="ContImgLoader" class="White">
        <div class="LogoCont">
            <img src="$viewsUrl/img/pngMakefs.png" alt="LogoMakef's">
        </div>
        <div class="PreloaderCont">
            <div class="ContTitle">
                <h1>Makef's</h1>
                <h6>Making chefs</h6>
            </div>
            <div class="Preloader">
                <img src="$viewsUrl/img/pngchef.png" alt="Chef">
            </div>
            <div class="loadingg">
                <h3>Preparando tu pagina</h3>
                <h3 class="dots">...</h3>
            </div>
        </div>
    </section>
EOT;
?>