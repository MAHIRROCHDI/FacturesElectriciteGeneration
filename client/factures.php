<?php 
require("../connexion.php") ; 
session_start(); 
date_default_timezone_set("Africa/Casablanca") ;
if(!isset($_SESSION['client_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
} ;
$id_client = $_SESSION['client_id'] ;
$sql = "SELECT * FROM facture WHERE idClient='$id_client' AND facture.valide = 'oui' ORDER BY dateFacture DESC" ; 
$factures = mysqli_query($conn,$sql) ; 

?>
<?php 
    $title = "Listes des factures" ; 
    include('../component/headA.php')
?>
<div class="page d-flex">
    <?php include("../component/sideBarC.php")?>
    <div class="content w-full">
        <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Voir Factures</h1>
            <!-- start table client -->
            <div class="projects p-20 bg-white rad-10 m-20">
                <h2 class="mt-0 mb-20">Listes des Factrures</h2>
                <div class="responsive-table">
                    <table class="fs-15 w-full">
                        <thead>
                            <tr>
                                <td>Annee</td>
                                <td>Mois</td>
                                <td>Facture</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($factures)){
                                $d = date_create($row['dateFacture']) ;
                                $anne =  date_format($d , "Y") ; 
                                $mois =  date_format($d , "M") ; 
                                echo '<tr>' ; 
                                    echo '<td>'.$anne.'</td>' ; 
                                    echo '<td>'.$mois.'</td>' ; 
                                    echo '<td>
                                        <a class="label bg-orange c-white btn-shape" href ="facture.php?id='.$row['idFacture'].'">Voir</a>
                                    </td>' ;
                                echo '</tr>' ; 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div> 
</div> 
</body>
</html>