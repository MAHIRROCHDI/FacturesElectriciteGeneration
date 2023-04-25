
<?php 
require("../connexion.php") ; 
require "../vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;
session_start(); 
date_default_timezone_set("Africa/Casablanca") ;
if(!isset($_SESSION['client_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
};
$id_client = $_SESSION['client_id'] ;
if(isset($_POST['payer'])){
    $idfacture = filter_input(INPUT_POST,'idFacture') ; 
    $sql ="SELECT payer FROM facture WHERE idFacture ='$idfacture'"  ; 
    $result = mysqli_query($conn , $sql) ; 
    if($result){
        $payer = $result->fetch_column() ; 
        if($payer === "oui"){
            // echo '<script>alert("vous avez deja paye cette facture !")</script>' ; 
            header("Location: facture.php?id=" . $idfacture ."&error=paid");
            exit() ;
        }
        else {
            $update = "UPDATE facture SET payer= 'oui' WHERE idFacture='$idfacture'" ; 
            $exec = mysqli_query($conn , $update) ; 
            if($exec){
                header("Location: facture.php?id=" . $idfacture ."&succe=paid");
                exit() ;
            }
        }
    }
}
if(isset($_POST['telecharger'])){
    $idfacture = filter_input(INPUT_POST,'idFacture') ; 
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
    $sql = "SELECT * FROM facture Where idFacture = '$idfacture'" ; 
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
    $options = new Options();
    $options->setChroot(__DIR__ . "/");
    $options->setIsRemoteEnabled(true);
    $dompdf = new Dompdf($options);
    $html = file_get_contents("factureTemplate.html");
        $html = str_replace(["{{ date }}" ,"{{ name }}" , "{{ prenom }}" , "{{ cin }}" , "{{ add }}" , "{{ agent }}" , "{{ moisFacture }}" ,"{{ annFacture }}" , "{{ consomationMent }}" , "{{ montantHT }}", "{{ montantTTC }}", "{{ delai }}"] ,
        [$date, $name ,$prenom,$cin , $add ,$agent, $moisFacture , $annFacture , $consomationMent , $montantHT , $montantTTC , $delai] ,
        $html) ;
    $dompdf->loadHtml($html);

    $dompdf->render();

    $dompdf->addInfo("Title", "Facture Pdf");  
    $dompdf->stream("invoice.pdf", ["Attachment" => 0]);

    /**
     * Save the PDF file locally
     */
    $output = $dompdf->output();
    file_put_contents("Facture.pdf", $output);   
}