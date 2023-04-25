<?php 
require("../connexion.php") ; 
session_start() ; 
if(!isset($_SESSION['admin_id'])){
    header("Location:../login.php") ; 
    exit(0) ;
}
$sql = 'SELECT client.*, zonegeographique.nomZone AS zone_name FROM client JOIN zonegeographique ON client.zone_geo = zonegeographique.idZone'; 
$clients = $conn->query($sql); 
?>
<?php 
    $title = "Gerer Clients" ; 
    include('../component/headA.php')
?>
<div class="page d-flex">
    <?php include("../component/sideBarA.php")?>
    <div class="content w-full">
        <?php include("../component/headerUsers.php")?>
        <h1 class="p-relative">Gerer Clients</h1>
            <!-- start table client -->
            <div class="projects p-20 bg-white rad-10 m-20">
                <h2 class="mt-0 mb-20">Listes des Clients</h2>
                <div class="responsive-table">
                    <table class="fs-15 w-full">
                        <thead>
                            <tr>
                                <td>Nom</td>
                                <td>Prenom</td>
                                <td>CIN</td>
                                <td>Zone Geographique</td>
                                <td>Address</td>
                                <td>Modifier</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($clients)){
                                echo '<tr>' ; 
                                    echo '<td>'.$row['nom'].'</td>' ; 
                                    echo '<td>'.$row['prenom'].'</td>' ; 
                                    echo '<td>'.$row['cin'].'</td>' ; 
                                    echo '<td>'.$row['zone_name'].'</td>' ; 
                                    echo '<td>'.$row['address'].'</td>' ; 
                                    echo '<td>
                                        <a class="label bg-red c-white btn-shape" href ="modifier.php?id='.$row['idClient'].'">Modifier</a>
                                    </td>' ;
                                echo '</tr>' ; 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <a class="ajouter-client" href="ajouter.php">Ajouter</a>
    <!-- end table clients-->
    </div>
</div>
</body>
</html>