<?php 
require("../connexion.php") ; 
session_start() ; 
if(!isset($_SESSION['admin_id'])){
    header("Location:../login.php") ; 
    exit(0) ;
}
$sql = "SELECT reclamation.*  , client.* FROM reclamation , client where reclamation.idClient = client.idClient AND reclamation.status = 'non_traiter'"; 
$reclamations = $conn->query($sql); 
?>
<?php 
    $title = "Voir Reclamations" ; 
    include('../component/headA.php') ;
?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarA.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Reclamations</h1>
            <div class="projects p-20 bg-white rad-10 m-20">
                <h2 class="mt-0 mb-20">Les reclamations non traites</h2>
                <div class="responsive-table">
                    <table class="fs-15 w-full">
                        <thead>
                            <tr>
                                <td>Client</td>
                                <td>Date Reclamation</td>
                                <td>Type Reclamation</td>
                                <td>Status</td>
                                <td>Details Reclamation</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($reclamations)){
                                echo '<tr>' ; 
                                    echo '<td>'.$row['cin'].'</td>' ; 
                                    echo '<td>'.$row['dateReclamation'].'</td>' ; 
                                    echo '<td>'.$row['typeReclamation'].'</td>' ; 
                                    echo '<td>'.$row['status'].'</td>' ; 
                                    echo '<td>
                                        <a class="label bg-red c-white btn-shape" href ="detailRec.php?id='.$row['idReclamation'].'">voir</a>
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
        </div>