<?php 
require("../connexion.php") ; 
session_start(); 
if(!isset($_SESSION['client_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
} ;
$id_client = $_SESSION['client_id'] ; 
date_default_timezone_set("Africa/Casablanca") ;
$sql = "SELECT * FROM reclamation WHERE idClient = '$id_client' and status='traiter' ORDER BY idReclamation DESC LIMIT 1" ;
$result = mysqli_query($conn ,$sql) ; 
if($result){
    $row = mysqli_fetch_assoc($result) ; 
}

?>
<?php 
    $title = "Dernier Reclamation" ; 
    include '../component/headA.php' ; 
?>
    <body>
        <div class="page d-flex">
            <?php include("../component/sideBarC.php")?>
            <div class="content w-full">
                <?php include("../component/headerUsers.php")?>
                <h1 class="p-relative">Reclamation</h1>
                <div class="Quick-draft p-20 bg-white rad-10 m-20 w-600">
                    <?php if($row){ ?>
                    <p class="mt-0 mb-20 c-gray fs-15">La Reponse d'admin a rpopos Votre derniere Reclamation au date <?php echo $row['dateReclamation'] ?>: </p>
                    <form class="reclamation" action="" method="POST">
                        <input class="d-block mb-20 w-full p-10 rad-6 b-none bg-eee" value="<?php echo $row['typeReclamation']?>" readonly>
                        <textarea class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" name="description" readonly><?php echo $row['contenueRec']?></textarea>
                        <textarea class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" name="reponse" readonly><?php echo $row['RepondreAdmin'] ?></textarea>
                    </form>
                    <?php } else{
                        echo '<p class="mt-0 mb-20 c-gray fs-15">Vous avez efectuez aucune Reclamation jusqu\'a presence!</p>' ;
                    } ?>
                </div>
                <a class="ajouter-client" href="reclamation.php">Noveau Reclamation</a>
            </div>
        </div>
        <script src="../js/main.js"></script>
    </body>
</html>