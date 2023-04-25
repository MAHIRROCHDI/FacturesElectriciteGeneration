<?php 
require("../connexion.php") ; 
session_start(); 
date_default_timezone_set("Africa/Casablanca") ;
if(!isset($_SESSION['admin_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
};
$id_consomation = $conn->real_escape_string($_GET['id']); 
if(isset($_POST['valider'])){
    $id = $conn->real_escape_string($_POST['id']) ;
    $connsomation = $conn->real_escape_string(filter_input(INPUT_POST,'consomation',FILTER_VALIDATE_FLOAT)) ;
    $sql = "UPDATE consomation SET consomationConteur = '$connsomation' WHERE idConsomation = '$id'"; 
    $result = mysqli_query($conn , $sql) ; 
    $TVA = 0.14 ; 
    if($result){
        //facture update : 
        $sql = "SELECT * FROM consomation WHERE idConsomation = '$id'";
        $exec = mysqli_query($conn, $sql);
        if ($exec) {
            $row = mysqli_fetch_assoc($exec);
            $consomationMois =  $connsomation - $row['previousConsomationComp'] ;
            $idClient = $row['idClient'] ;
            $annee = $row['annee'] ;
            $mois = $row['mois'] ;   
            $anneePrecedent = date('Y', strtotime("$annee -1 year"));
            //cas de mois 1 : 
            if($mois === "1"){
                $select = "SELECT (comnsomationAnnParAgent-consomationAnn) as diffConsomation FROM consomationann WHERE idClient = '$idClient' AND annee ='$anneePrecedent'" ;
                $resul = mysqli_query($conn , $select) ; 
                if($resul){
                    $diffConsomation = $resul->fetch_column() ; 
                    if($diffConsomation > 0 ) {
                        if(abs($diffConsomation) > 100){
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
            if($mois === "1") {
                $montantTTC += $montantTTCAdd ;
                $montantHT += $montantHTAdd;  
            }
            $updateFacture = mysqli_query($conn , "UPDATE facture SET montantTTC = '$montantTTC' , montantHT = '$montantHT' , consomationMensuel = '$consomationMois' , valide = 'oui' WHERE idConsomation = '$id_consomation'") ;
            //Insert consomation Annuell  pour les client dont la consomation du mois c'est pas dans l'interval :
            if($updateFacture) {
                if($mois === "12" ){
                    $select = "SELECT SUM(consomationMensuel) as consomationAnn FROM facture WHERE facture.idClient = '$idClient' AND YEAR(dateFacture) = '$annee'" ;
                    $execution = mysqli_query($conn , $select) ;
                    if($execution){
                        $consomationAnn = $execution->fetch_column(); 
                        $insertConAnn = "INSERT INTO consomationann(idClient , annee , consomationAnn) VALUES('$idClient' , '$annee' , '$consomationAnn')" ; 
                        $query = mysqli_query($conn , $insertConAnn) ; 
                    }
                }
                $message[] = 'La facture du client est genere' ; 
            }
            else {
                $message[] = 'Probleme dans la generation de la facture!!' ;
            }
        }
    }
}
$sql = "SELECT * FROM consomation WHERE idConsomation = '$id_consomation'";
$query = mysqli_query($conn, $sql);
if ($query) {
    $row = mysqli_fetch_assoc($query);
}
?>

<?php 
    $title = "Verifier Consomation" ; 
    include('../component/headA.php')
?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarA.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Detail de Consommation</h1>
            <div class="courses-page d-grid gap-20 m-20">
                <?php
                    if(isset($message)){
                        foreach($message as $msg) {
                            echo '<div class = "message" >'.$msg.'</div>' ; 
                        }
                    } 
                ?>
                <div class="course bg-white rad-6 p-relative">
                    <h4 class="mt-0 mb-20 p-20">Image du Compteur </h4>
                    <img class="cover txt-c" src="../client/uploaded_compteur/<?php echo $row['compteurImg']?>" alt="cc">
                    <div class="p-20">
                        <h4 class="mt-0 mb-10">Consomation Saisi par client </h4>
                        <form action="" method="POST" enctype="multipart/form-data">
                        <input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="hidden" name="id" value="<?php echo isset($row['idConsomation']) ? $row['idConsomation']:""?>">
                            <input class="d-block mb-20 w-full p-10 rad-6 b-none bg-eee" type="text" name="consomation" value="<?php echo isset($row['consomationConteur']) ? $row['consomationConteur']:""?>">
                            <div class="info p-15 p-relative between-flex b-top fs-13">
                            <input class="title d-block fs-14 bg-blue c-white b-none w-fit btn-shape" type="submit" name="valider" value="Valider">
                            </div>
                        </from>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>
