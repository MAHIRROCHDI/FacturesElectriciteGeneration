<?php 
require("../connexion.php") ; 
session_start() ; 
if(!isset($_SESSION['admin_id'])){
    header("Location:../login.php") ; 
    exit(0) ;
}
$idReclamation =$conn->real_escape_string($_GET['id']);
$sql = "SELECT reclamation.* , client.* FROM reclamation , client WHERE reclamation.idClient = client.idClient and idReclamation = '$idReclamation'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
}
if(isset($_POST['repondre'])){
    $reponse = mysqli_real_escape_string($conn,filter_input(INPUT_POST , 'reponse')) ; 
    $sql = "UPDATE reclamation set RepondreAdmin = '$reponse', status='traiter' WHERE idReclamation = '$idReclamation'" ;
    $result = mysqli_query($conn , $sql) ; 
    if($result){
        $message[] = 'Reponse Envoyer Avec Succes';
    }
    else {
        $message[] = 'Reponse n\'est pas Envoyer';
    }
}
?>
<?php 
    $title = "Details Reclamation" ; 
    include '../component/headA.php' ; 
?>
    <body>
        <div class="page d-flex">
            <?php include("../component/sideBarA.php")?>
            <div class="content w-full">
                <?php include("../component/headerUsers.php")?>
                <h1 class="p-relative">Details Reclamation</h1>
                <div class="Quick-draft p-20 bg-white rad-10 m-20 w-600">
                    <?php
                        if(isset($message)){
                            foreach($message as $msg) {
                                echo '<div class = "message" >'.$msg.'</div>' ; 
                            }
                        } 
                    ?>
                    <p class="mt-0 mb-20 c-gray fs-15">Reclamation d'apres monsieur <?php echo $row['nom']." ".$row['prenom']." au date ".$row['dateReclamation'] ?></p>
                    <form class="reclamation" action="" method="POST">
                        <input value="Facture" class="d-block mb-20 w-full p-10 rad-6 b-none bg-eee" readonly>
                        <textarea class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" name="description" readonly><?php echo $row['contenueRec']?></textarea>
                        <textarea class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" name="reponse" placeholder="Votre Reponse"></textarea>
                        <input class="save btn-shape bg-orange c-white b-none" type="submit" value="Repondre" name="repondre" >
                    </form>
                </div>
            </div>
        </div>
        <script src="../js/main.js"></script>
    </body>
</html>