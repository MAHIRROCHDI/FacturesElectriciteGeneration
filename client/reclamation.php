<?php 
require("../connexion.php") ; 
session_start(); 
if(!isset($_SESSION['client_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
} ;
$id_client = $_SESSION['client_id'] ; 
date_default_timezone_set("Africa/Casablanca") ;
if(isset($_POST['envoyer'])){
    if($_POST['typeRec'] !== "autre"){
        $type_rec = filter_input(INPUT_POST , 'typeRec') ; 
    }
    else {
        $type_rec = filter_input(INPUT_POST , 'autre') ; 
    }
    $rec_content =  mysqli_real_escape_string($conn,filter_input(INPUT_POST , 'description')) ; 
    $date = date("Y-m-d H:i:s") ; 
    $sql = "INSERT INTO reclamation(idClient , dateReclamation , typeReclamation ,contenueRec) VALUES('$id_client','$date','$type_rec','$rec_content')" ; 
    $insert = $conn->query($sql) ; 
    if($insert){
        $message[] = 'Votre Reclamation bien Envoyer' ; 
    }
    else {
        $message[] = "Votre Reclamation n'est pas envoyer" ; 
    }
}
?>
<?php 
    $title = "Faire Reclamation" ; 
    include '../component/headA.php' ; 
?>
    <body>
        <div class="page d-flex">
            <?php include("../component/sideBarC.php")?>
            <div class="content w-full">
                <?php include("../component/headerUsers.php")?>
                <h1 class="p-relative">Faire Reclamation</h1>
                <div class="Quick-draft p-20 bg-white rad-10 m-20 w-600">
                    <?php
                        if(isset($message)){
                            foreach($message as $msg) {
                                echo '<div class = "message" >'.$msg.'</div>' ; 
                            }
                        } 
                    ?>
                    <p class="mt-0 mb-20 c-gray fs-15">Ecrire Votre Reclamation</p>
                    <form class="reclamation" action="" method="POST">
                        <select class="d-block mb-20 w-full p-10 rad-6 b-none bg-eee" name="typeRec" required>
                            <option value="Fuite Externe / Interne">Fuite Externe / Interne</option>
                            <option value="Facture">Facture</option>
                            <option value="autre">Autre</option>
                        </select>
                        <textarea class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" name="description" placeholder="Contenu de votre Reclamation" required></textarea>
                        <input class="save btn-shape bg-orange c-white b-none m-auto" type="submit" value="Envoyer" name="envoyer" required>
                    </form>
                </div>
            </div>
        </div>
        <script src="../js/main.js"></script>
    </body>
</html>