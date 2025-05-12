<?php
session_start();

try {
    include_once("../vendor/autoload.php");
    include_once("../models/conexion.php");
    include("jwtController.php");
} catch (Exception $th) {

}
include("/makefs/views/components/test_inputs.php");
    if(isset($_POST['cerrar_sesion'])){
        destroyToken($_SESSION["token"]);
        include('controllers/cerrar.php');
        header("Location: /login");
    }
    if(isset($_SESSION['auth'])){
        header("Location: /");      
    }

    if(isset($_POST['logeo'])){
        
        if(isset($_POST['username']) && isset($_POST['pw'])){

            // $actualDate = date("Y-m-d H:i:s", time());
            // $objConn = new Conexion;
            // $conexion = $objConn->Conectar();
            // $sql = "SELECT * FROM userm WHERE username='$_POST[username]'";
            // $cleanBlackTokens = "DELETE FROM jwt_tokens_blacklist WHERE expires < '$actualDate'";

            // $userLog = $conexion->prepare($sql);
            // $cleanBLJWT = $conexion->prepare($cleanBlackTokens);
            // try{
            //     $conexion->beginTransaction();
            //     $cleanBLJWT->execute();
            //     $userLog->execute();
            //     $conexion->commit(); 
            //     $user = $userLog->fetch(PDO::FETCH_ASSOC);
            // }catch(Exception $e){
            //     $conexion->rollBack();
            //     echo "Failed: " . $e->getMessage();
            // }
            
            $contraIngresada = $_POST['pw'];

                    session_start();
                                 
                    $_SESSION["id"] = "112456";
                    $_SESSION["nombre"] = "Omar Contreras";
                    $_SESSION["username"] =  "OmarCL9";
                    $_SESSION["email"] = "goguillos2@gmail.com";
                    $_SESSION["nacimiento"] = "2005-03-05";
                    $_SESSION["description"] = "Hola soy un estudiante de la ibero!";
                    $_SESSION["midpic"] = "a";
                    $_SESSION["minpic"] = "a";
                    $_SESSION["chefid"]= null;
                    $_SESSION["rol"]='admin';
                    $_SESSION["facebook"]= "a";
                    $_SESSION["instagram"]= "a";
                    $_SESSION["youtube"]= "a";
                    $_SESSION["twitter"]= "a";

                    $password = "goguillos";
                    $token = generateToken($_SESSION["username"], $password);
                    $token = json_decode($token);
                    $token = $token->access_token;
                    $_SESSION["watched_in_session_list"] = array();

                    if(isset($_SESSION["errorLog"])){
                        unset($_SESSION["errorLog"]);
                    }

                    if(isset($_SESSION["errorRegister"])){
                        unset($_SESSION["errorRegister"]);
                    }
                    
                    $_SESSION["token"] = $token;
                    header("location: /makefs/user");
                    

                }else{
                    $_SESSION["errorLog"] = "contrasena";
                    header("location: /makefs/login");
                }
                
        
    }
    echo "</div>";
?>