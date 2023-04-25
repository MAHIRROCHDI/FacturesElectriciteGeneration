<?php 
require("../connexion.php") ; 
session_start(); 
date_default_timezone_set("Africa/Casablanca") ;
if(!isset($_SESSION['client_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
} ;
$id_client = $conn->real_escape_string($_SESSION['client_id']) ;
$d = date_create("2023-04-28");  
$mois = $conn->real_escape_string(date_format($d , "m")) ; 
$annee = $conn->real_escape_string(date_format($d , "Y"))  ; 
$anneePrecedent = date('Y', strtotime("$annee -1 year"));
$TVA = 0.14 ; 
if($mois === "01"){
    $select = "SELECT (comnsomationAnnParAgent-consomationAnn) as diffConsomation FROM consomationann WHERE idClient = '$id_client' AND annee ='$anneePrecedent'" ;
    $resul = mysqli_query($conn , $select) ; 
    if($resul){
        $diffConsomation = $resul->fetch_column() ; 
        if($diffConsomation > 0 ) {
            if(abs($diffConsomation) > 100){
                echo '<script> alert("vous avez un credit de ' . abs($diffConsomation) . ' KWH d\'apres l\'annee precedent , on va l\'ajouter dans ce mois!")</script>';
                if(abs($diffConsomation) >= 101 && abs($diffConsomation) <= 200) {
                    $montantHTAdd =  +abs($diffConsomation)*1.01 ;
                }
                else {
                    $montantHTAdd =  +abs($diffConsomation)*1.12 ;
                }
                $montantTTCAdd = $montantHTAdd*(1+$TVA) ; 
            }
            else {
                $montantHTAdd = 0 ; 
                $montantTTCAdd = 0 ; 
            }
        }
        else {
            if(abs($diffConsomation) > 100){
                echo '<script> alert("vous avez un debit de ' . abs($diffConsomation) . ' KWH d\'apres l\'annee precedent , on va la soustrait dans ce mois!")</script>';
                if(abs($diffConsomation) >= 101 && abs($diffConsomation) <= 200) {
                    $montantHTAdd = -abs($diffConsomation)*1.01 ;
                }
                else {
                    $montantHTAdd = -abs($diffConsomation)*1.12 ;
                }
                $montantTTCAdd = $montantHTAdd*(1+$TVA) ;
            }
            else {
                $montantHTAdd = 0 ; 
                $montantTTCAdd = 0 ; 
            }
        }
    }
}
if(isset($_POST['saisir'])){
    $consomation = filter_input(INPUT_POST , 'consomation' , FILTER_VALIDATE_FLOAT) ; 
    $image = $_FILES['compteur'] ;
    $image_name = $image['name'] ; 
    $image_tmp_name = $image['tmp_name'] ; 
    $image_folder = 'uploaded_compteur/'.$image_name  ; 
    //calcul de consomation Compteur saisir dans le mois precedent 
    $select= "SELECT consomationConteur FROM consomation WHERE idClient = '$id_client' ORDER BY idConsomation DESC LIMIT 1" ; 
    $result = mysqli_query($conn , $select) ;  
    if(mysqli_num_rows($result) > 0) {
        $previousConsomation = $result->fetch_column() ; 
    }
    else {
        $previousConsomation = 0 ; 
    }
    if($consomation - $previousConsomation > 0 ){
        $select = mysqli_query($conn , "SELECT mois, annee FROM consomation WHERE idClient='$id_client' AND mois = '$mois' AND annee = '$annee'") ; 
        if(mysqli_num_rows($select) > 0) {
            $message[] = 'Vous avez deja saisi la consommation de ce mois!!!' ; 
        }
        else {
            //calcul de consomation du mois : 
            $consomationMois =  $consomation - $previousConsomation ; 
            $insert = mysqli_query($conn , "INSERT INTO consomation(idClient , consomationConteur , mois , annee, compteurImg , previousConsomationComp) VALUES('$id_client', '$consomation','$mois', '$annee' , '$image_name','$previousConsomation')") ;
            if($insert){
                $selectIdCons = mysqli_query($conn,"SELECT idConsomation FROM consomation Where idClient ='$id_client' AND mois = '$mois' AND annee = '$annee'") ;
                $idConsomation = $selectIdCons->fetch_column() ; 
                move_uploaded_file($image_tmp_name , $image_folder) ; 
                
                //---------facture--------- :
    
                $date_facture = date_format($d , "Y-m-d") ; 
                if($consomationMois <= 100) {
                    $montantHT = $consomationMois*0.91 ; 
                }
                else if($consomationMois >= 101 && $consomationMois <= 200) {
                    $montantHT = $consomationMois*1.01 ;
                }
                else {
                    $montantHT = $consomationMois*1.12 ;
                }
                $montantTTC = $montantHT*(1+$TVA) ; 
                if($mois === "01") {
                    $montantTTC += $montantTTCAdd ;
                    $montantHT += $montantHTAdd;  
                }
                $insrt = mysqli_query($conn , "INSERT INTO facture(idClient ,idConsomation, dateFacture,montantTTC,montantHT,mois, consomationMensuel ) 
                VALUES('$id_client','$idConsomation','$date_facture','$montantTTC','$montantHT','$mois','$consomationMois')") ;
                if($insrt){
                    if($consomationMois >= 50 && $consomationMois <= 400 ) {
                        $sql = "UPDATE facture SET valide = 'oui' WHERE idClient = '$id_client' AND dateFacture = '$date_facture'";
                        $result = mysqli_query($conn, $sql);
                        //insertion du consomation Annuelle : 
                        if($mois === "12" ){
                            $select = "SELECT SUM(consomationMensuel) as consomationAnn FROM facture WHERE facture.idClient = '$id_client' AND YEAR(dateFacture) = '$annee'" ;
                            $execution = mysqli_query($conn , $select) ;
                            if($execution){
                                $consomationAnn = $execution->fetch_column(); 
                                $insertConAnn = "INSERT INTO consomationann(idClient , annee , consomationAnn) VALUES('$id_client' , '$annee' , '$consomationAnn')" ; 
                                $query = mysqli_query($conn , $insertConAnn) ; 
                            }
                        }
                    }
                }
                $message[] = 'consomation Enregistre avec succees' ; 
            }
            else {
                $message[] = 'Echec d\'envoi' ; 
            }
        }
    }
    else {
        $message[] = 'Inserer une Consommation Valide!' ; 
    }
} 
?>
<?php 
    $title = "Saisir Consomation" ; 
    include '../component/headA.php' ; 
 ?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarC.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Saisir Consommation</h1>
            <div class="Quick-draft p-20 bg-white rad-10 m-20 w-600">
                <?php
                    if(isset($message)){
                        foreach($message as $msg) {
                            echo '<div class = "message" >'.$msg.'</div>' ; 
                        }
                    } 
                ?>
                
                <p class="mt-0 mb-20 c-gray fs-15">Saisir Consomation du mois</p>
                <span class="d-inline-block  mr-15 mb-10">Mois : <?php echo $mois ?></span>
                <span class="d-inline-block mb-10">Annee : <?php echo $annee ?></span>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input class="d-block mb-20 w-full p-10 rad-6 b-none bg-eee" type="text" name="consomation" placeholder="La consommation en KWH" required>
                    <input class="d-block mb-20 w-full p-10 rad-6 b-none bg-eee" type="file" name="compteur" required>
                    <input class="save btn-shape bg-orange c-white b-none m-auto" type="submit" value="Saisir" name="saisir">
                </form>
        </div>
    </div>
</body>