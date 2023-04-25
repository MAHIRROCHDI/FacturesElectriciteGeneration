<?php 
require("../connexion.php") ; 
session_start() ; 
if(!isset($_SESSION['admin_id'])){
    header("Location:../login.php") ; 
    exit(0) ;
}
$sql = "SELECT client.* , consomation.* , facture.idFacture From client , facture , consomation Where client.idClient = facture.idClient and client.idClient = consomation.idClient AND facture.idConsomation = consomation.idConsomation AND facture.valide = 'non' ORDER BY facture.dateFacture" ;
$result = mysqli_query($conn , $sql) ; 
?>
<?php 
    $title = "Verifier Consomations" ; 
    include('../component/headA.php')
?>
<div class="page d-flex">
    <?php include("../component/sideBarA.php")?>
    <div class="content w-full">
        <?php include("../component/headerUsers.php")?>
        <h1 class="p-relative">Verifier Consomations</h1>
            <!-- start table client -->
            <div class="projects p-20 bg-white rad-10 m-20">
                <h2 class="mt-0 mb-20">Consomation a verifier</h2>
                <div class="responsive-table">
                    <table class="fs-15 w-full">
                        <thead>
                            <tr>
                                <td>CIN client</td>
                                <td>Mois</td>
                                <td>Annee</td>
                                <td>Consomation Saisi</td>
                                <td>Details</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($result)){
                                echo '<tr>' ; 
                                    echo '<td>'.$row['cin'].'</td>' ; 
                                    echo '<td>'.$row['mois'].'</td>' ; 
                                    echo '<td>'.$row['annee'].'</td>' ; 
                                    echo '<td>'.$row['consomationConteur'].' KWH</td>' ; 
                                    echo '<td>
                                        <a class="label bg-blue c-white btn-shape" href ="detailsVerif.php?id='.$row['idConsomation'].'">Verifier</a>
                                    </td>' ;
                                echo '</tr>' ; 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    <!-- end table clients-->
    </div>
</div>
</body>
</html>