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
        <figure id="btnCategoriesShow" class="WhiteBtnDown"></figure>
        <div class="categories-down WhiteModeCategories" id="menuCATE">
            <div class="categoryDiv Whiteindice" >
                <a id="latamCate">
                    <img src="$viewsUrl/img/latamCat.png" alt="Colombian">
                    <h2 >Latam</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a id="asiaCate">
                    <img src="$viewsUrl/img/asiaCat.png" alt="Italian">
                    <h2>Asia</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a id="norteamericaCate">
                    <img src="$viewsUrl/img/norteamericaCat.png" alt="Mexican">
                    <h2>Norte.A</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a id="europaCate">
                    <img src="$viewsUrl/img/europaCat.png" alt="Vegetarian">
                    <h2>Europa</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice" >
                <a id="africaCate">
                    <img src="$viewsUrl/img/africaCat.png" alt="Hamburguesa">
                    <h2>Africa</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice" >
                <a id="oceaniaCate">
                    <img src="$viewsUrl/img/oceaniaCat.png" alt="Hamburguesa">
                    <h2>Oceania</h2>
                </a>
            </div>
        </div>
        <div class="subcategories-down WhiteModesubCategories" id="latinoamerica">
            <div class="categoryDiv Whiteindice returnBtn">
                <a href="#">
                    <h2><<</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/latam/sopas">
                    <img src="$viewsUrl/img/sopaCat.png" alt="Colombian">
                    <h2>Sopas</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href./category.php?latam/vegana">
                    <img src="$viewsUrl/img/vegetarianCat.png" alt="Italian">
                    <h2>Vegana</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/latam/gourmet">
                    <img src="$viewsUrl/img/gourmetCat.png" alt="Mexican">
                    <h2>Gourmet</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/latam/postres">
                    <img src="$viewsUrl/img/postresCat.png" alt="Mexican">
                    <h2>Postres</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/latam/casero">
                    <img src="$viewsUrl/img/caseroCat.png" alt="Vegetarian">
                    <h2>Casero</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/latam/tipicas">
                    <img src="$viewsUrl/img/latamTipica.png" alt="Hamburguesa">
                    <h2>Tipicas</h2>
                </a>
            </div>
            
        </div>
        <div class="subcategories-down WhiteModesubCategories" id="asia">
            <div class="categoryDiv Whiteindice returnBtn">
                <a href="#">
                    <h2><<</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/asia/sopas">
                    <img src="$viewsUrl/img/sopaCat.png" alt="Colombian">
                    <h2>Sopas</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/asia/vegana">
                    <img src="$viewsUrl/img/vegetarianCat.png" alt="Italian">
                    <h2>Vegana</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/asia/gourmet">
                    <img src="$viewsUrl/img/gourmetCat.png" alt="Mexican">
                    <h2>Gourmet</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/asia/postres">
                    <img src="$viewsUrl/img/postresCat.png" alt="Mexican">
                    <h2>Postres</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/asia/casero">
                    <img src="$viewsUrl/img/caseroCat.png" alt="Vegetarian">
                    <h2>Casero</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/asia/tipicas">
                    <img src="$viewsUrl/img/asiaTipica.png" alt="Hamburguesa">
                    <h2>Tipicas</h2>
                </a>
            </div>
            
        </div>
        <div class="subcategories-down WhiteModesubCategories" id="norteamerica">
            <div class="categoryDiv Whiteindice returnBtn">
                <a href="#">
                    <h2><<</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/nortea/sopas">
                    <img src="$viewsUrl/img/sopaCat.png" alt="Colombian">
                    <h2>Sopas</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/nortea/vegana">
                    <img src="$viewsUrl/img/vegetarianCat.png" alt="Italian">
                    <h2>Vegana</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/nortea/gourmet">
                    <img src="$viewsUrl/img/gourmetCat.png" alt="Mexican">
                    <h2>Gourmet</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/nortea/postres">
                    <img src="$viewsUrl/img/postresCat.png" alt="Mexican">
                    <h2>Postres</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/nortea/casero">
                    <img src="$viewsUrl/img/caseroCat.png" alt="Vegetarian">
                    <h2>Casero</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/nortea/tipicas">
                    <img src="$viewsUrl/img/norteamericaTipica.png" alt="Hamburguesa">
                    <h2>Tipicas</h2>
                </a>
            </div>
            
        </div>
        <div class="subcategories-down WhiteModesubCategories" id="europa">
            <div class="categoryDiv Whiteindice returnBtn">
                <a href="#">
                    <h2><<</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/europa/sopas">
                    <img src="$viewsUrl/img/sopaCat.png" alt="Colombian">
                    <h2>Sopas</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/europa/vegana">
                    <img src="$viewsUrl/img/vegetarianCat.png" alt="Italian">
                    <h2>Vegana</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/europa/gourmet">
                    <img src="$viewsUrl/img/gourmetCat.png" alt="Mexican">
                    <h2>Gourmet</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/europa/postres">
                    <img src="$viewsUrl/img/postresCat.png" alt="Mexican">
                    <h2>Postres</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/europa/casero">
                    <img src="$viewsUrl/img/caseroCat.png" alt="Vegetarian">
                    <h2>Casero</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/europa/tipicas">
                    <img src="$viewsUrl/img/europaTipica.png" alt="Hamburguesa">
                    <h2>Tipicas</h2>
                </a>
            </div>
            
        </div>
        <div class="subcategories-down WhiteModesubCategories" id="africa">
            <div class="categoryDiv Whiteindice returnBtn">
                <a href="#">
                    <h2><<</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/africa/sopas">
                    <img src="$viewsUrl/img/sopaCat.png" alt="Colombian">
                    <h2>Sopas</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/africa/vegana">
                    <img src="$viewsUrl/img/vegetarianCat.png" alt="Italian">
                    <h2>Vegana</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/africa/gourmet">
                    <img src="$viewsUrl/img/gourmetCat.png" alt="Mexican">
                    <h2>Gourmet</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/africa/postres">
                    <img src="$viewsUrl/img/postresCat.png" alt="Mexican">
                    <h2>Postres</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/africa/casero">
                    <img src="$viewsUrl/img/caseroCat.png" alt="Vegetarian">
                    <h2>Casero</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/africa/tipicas">
                    <img src="$viewsUrl/img/africaTipica.png" alt="Hamburguesa">
                    <h2>Tipicas</h2>
                </a>
            </div>
            
        </div>
        <div class="subcategories-down WhiteModesubCategories" id="oceania">
            <div class="categoryDiv Whiteindice returnBtn">
                <a href="#">
                    <h2><<</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/oceania/sopas">
                    <img src="$viewsUrl/img/sopaCat.png" alt="Colombian">
                    <h2>Sopas</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/oceania/vegana">
                    <img src="$viewsUrl/img/vegetarianCat.png" alt="Italian">
                    <h2>Vegana</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/oceania/gourmet">
                    <img src="$viewsUrl/img/gourmetCat.png" alt="Mexican">
                    <h2>Gourmet</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/oceania/postres">
                    <img src="$viewsUrl/img/postresCat.png" alt="Mexican">
                    <h2>Postres</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/oceania/casero">
                    <img src="$viewsUrl/img/caseroCat.png" alt="Vegetarian">
                    <h2>Casero</h2>
                </a>
            </div>
            <div class="categoryDiv Whiteindice">
                <a href="/makefs/category/oceania/tipicas">
                    <img src="$viewsUrl/img/oceaniaTipica.png" alt="Hamburguesa">
                    <h2>Tipicas</h2>
                </a>
            </div>
            
        </div>
        
    EOT;
?>