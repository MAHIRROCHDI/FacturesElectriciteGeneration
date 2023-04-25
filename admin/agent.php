<?php 
require("../connexion.php") ; 
session_start(); 
date_default_timezone_set("Africa/Casablanca") ;
if(!isset($_SESSION['agent_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
};
$d = date_create("now");  
$date = $conn->real_escape_string(date_format($d , "Y-m-d"))  ;
if(isset($_POST['upload'])) {
    $filename = $_FILES['file']['tmp_name'];
    $handle = fopen($filename, 'r'); // open the file for reading
    if ($handle) {
        fgets($handle) ; 
        while (($line = fgets($handle)) !== false) {
            $data = explode(',', $line); // split the line into an array using comma as the delimiter
            $clientId = trim($data[0]);
            $consommation = trim($data[1]);
            $annee = trim($data[2]);
            $zoneGeogId = trim($data[3]);
            $dateSaisie = trim($data[4]);
            $update = "UPDATE consomationann SET comnsomationAnnParAgent = '$consommation' , dateSaisir = '$dateSaisie' WHERE idClient = '$clientId' and annee = '$annee'" ;
            $query = mysqli_query($conn , $update) ;  
        }
    fclose($handle); // close the file
    $message[] = 'fichier a ete Importe avec succe!' ;
}
}
?>

<?php 
    $title = "Importer Fichier" ; 
    include '../component/headA.php' ; 
 ?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarAg.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Importer Fichier</h1>
                <?php
                    if(isset($message)){
                        foreach($message as $msg) {
                            echo '<div class = "message" >'.$msg.'</div>' ; 
                        }
                    } 
                ?>
            <div class="files-page m-20 gap-20 df-align-start">
                <div class="files-content d-grid gap-20">
                    <!-- start file -->
                    <div class="file bg-white p-10 rad-10">
                        <span class="c-gray p-absolute fs-15"><?php echo $date?></span>
                        <div class="icon txt-c">
                            <img class="mt-15 mb-15" src="../images/txticon (2).png" alt="">
                            <div class="txt-c mb-10 fs-14">
                                exemple.txt
                            </div>
                            <p class="c-gray fs-13">Importer le fichier de la consommation Annuelle</p>
                            <div class="info mt-10 pt-10 fs-13 c-gray b-top"> 
                                <form action="" method = "POST" enctype="multipart/form-data">
                                    <input class=" d-block mb-10 w-full p-10 rad-6 b-none bg-eee" type="file" name="file" required>
                                    <input  class="upload bg-blue c-white fs-15 rad-6 w-fit b-none" type="submit" name="upload" value="Upload">
                                </form>       
                            </div>
                        </div>
                    </div>
                    <!-- end file -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>