<?php 
require("../connexion.php") ; 
session_start(); 
date_default_timezone_set("Africa/Casablanca") ;
if(!isset($_SESSION['client_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
};
$id_client = $_SESSION['client_id'] ;
$id_facture = $_GET['id'] ; 
$sql = "SELECT client.* , agent.numeroAgent as nomAgent , zonegeographique.nomZone as zonGeo 
FROM client , agent ,zonegeographique 
WHERE client.zone_geo = zonegeographique.idZone AND zonegeographique.idZone = agent.idZone AND client.idClient = '$id_client'" ;
$client = mysqli_query($conn , $sql) ; 
if($row = mysqli_fetch_assoc($client)){
    $agent = $row['nomAgent'] ; 
    $name = $row['nom'] ; 
    $prenom = $row['prenom'] ; 
    $cin = $row['cin'] ; 
    $add = $row['address'] ; 
}
$sql = "SELECT * FROM facture Where idFacture = '$id_facture'" ; 
$facture = mysqli_query($conn , $sql) ; 
if($facture){
    $row = mysqli_fetch_assoc($facture) ; 
    $d = date_create($row['dateFacture']) ;
    $d_delai = date_create($row['dateFacture']) ;
    $date = date_format($d, "Y-m-d") ;
    date_add($d_delai, date_interval_create_from_date_string("+14 days")) ; 
    $delai =date_format($d_delai ,"Y-m-d" ) ; 
    $moisFacture = date_format($d , "m") ; 
    $annFacture = date_format($d , "Y") ; 
    $consomationMent = $row['consomationMensuel'] ; 
    $montantTTC = $row['montantTTC'] ; 
    $montantHT = $row['montantHT'] ; 
}
?>
<?php
if (isset($_GET['error']) && $_GET['error'] == 'paid') {
  echo '<script>alert("Vous avez déjà payé cette facture !")</script>';
}
else if(isset($_GET['succe']) && $_GET['succe'] == 'paid') {
  echo '<script>alert("Fcature payé avec succees !")</script>';
}
?>
<?php 
    $title = "Detail facture" ; 
    include '../component/headA.php' ; 
?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarC.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Facture </h1>
            <?php
                if(isset($message)){
                    foreach($message as $msg) {
                        echo '<div class = "message" >'.$msg.'</div>' ; 
                    }
                } 
            ?>
            <div class="Quick-draft p-20 bg-white rad-10 m-20 w-600">
                <div class="between-flex">
                    <h2 class="c-orange mt-0 mb-0">Electrica</h2>
                    <?php echo'<span class="d-block"> '.$date.'</span>' ;?>
                </div>
                <h2 class="mt-0 mb-10 txt-c">Facture d'Electricite</h2>
                <!-- <p class="mt-0 mb-20 c-gray fs-15">facture </p> -->
                    <div class="info-perso mb-15 fs-15">
                        <?php echo'<span class="d-block"> Client : '.$name.' '.$prenom.'</span>' ;?>
                        <?php echo'<span class="d-block"> CIN  : '.$cin.'</span>' ;?>
                        <?php echo'<span class="d-block"> Address : '.$add.'</span>' ;?>
                        <?php echo'<span class="d-block"> Agent : '.$agent.'</span>' ;?>
                    </div>
                <!-- About facture  -->
                <div class="mb-15">
                    <span class="mr-10 d-block fs-14 txt-c">Votre Consommation du mois : <?php echo $moisFacture."/".$annFacture ;?></span> 
                </div>
                <div class="b-solid p-15 rad-10 mb-15">
                    <span class="c-gray fw-bold">Consomation : </span> <?php echo $consomationMent." KWH<br>" ;?> 
                    <span class="c-gray fw-bold">MontantHT : </span> <?php echo $montantHT." DH<br>" ;?> 
                    <span class="c-gray fw-bold"> Totale montant TTC : </span> <?php echo $montantTTC." DH<br>" ;?> 
                </div>
                <p class="fs-14 c-gray"><span class="c-red">NB :</span> Il faut paye cette facture avant : <?php echo $delai?></p>
                <div class="between-flex">
                    <span class="c-gray fs-14">*TVA : 14%</span>
                    <img  class="w-100 " src="../images/signature.png">
                </div>
            </div>
            <div class="info between-flex fs-13">
                <span class="c-gray"></span>
                <div class="info-facture">
                    <form action="../client/payerTelecharger.php" method="POST">
                        <input type="hidden" name="idFacture" value="<?php echo $id_facture?>">
                        <input class="bg-blue c-white b-none btn-shape" type="submit" value="Payer" name="payer" >
                        <input class="bg-green c-white b-none btn-shape" type="submit" value="Telecharger" name= "telecharger">
                    </form>
                </div>
            </div>
        </div>
    </div>