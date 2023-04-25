<?php 
require("../connexion.php") ; 
session_start() ; 
if(!isset($_SESSION['admin_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
} ; 
$sql =mysqli_query($conn ,  "SELECT SUM(montantTTC) FROM facture where payer = 'non'") ;
$factureNonPayee = $sql->fetch_column(); 
$nbrReclamation = mysqli_query($conn ,  "SELECT count(idReclamation) FROM reclamation where status = 'non_traiter'")->fetch_column() ;
$factureNonGenerer = mysqli_query($conn ,  "SELECT count(idFacture) FROM facture where valide = 'non'")->fetch_column() ;

$query = mysqli_query($conn , "SELECT sum(consomationMensuel) as sumCon , mois FROM facture group by mois") ;

foreach($query as $data){
    $month[] = $data['mois'] ; 
    $consomation[] = $data['sumCon'] ;
}
$sql = "SELECT SUM(facture.consomationMensuel) AS sumCon, zonegeographique.nomZone FROM facture JOIN client ON facture.idClient = client.idClient JOIN zonegeographique ON client.zone_geo = zonegeographique.idZone GROUP BY zonegeographique.idZone";
$results = mysqli_query($conn, $sql);
$zone = array();
$sumCon = array();
while ($row = mysqli_fetch_assoc($results)) {
    $zone[] = $row['nomZone']; 
    $sumCon[] = $row['sumCon']; 
}
?>

<?php 
    $title = "Dashboard" ; 
    include '../component/headA.php' ; 
 ?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarA.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Dashboard</h1>
            <div class="wrapper d-grid gap-20">
                <div class="tickets bg-white rad-10 p-20">
                    <h2 class="mt-0 mb-10">Quelques Statistics <i class="fa-solid fa-chart-simple c-blue"></i></h2>
                    <p class="mt-0 mb-20 c-gray fs-15"></p>
                    <div class="boxs d-grid gap-20">
                        <div class="box rad-10 b-solid txt-c c-gray p-20">
                        <img src="../images/cost.png" alt="img1" >
                            <span class="d-block fw-bold mt-0 mb-5 fs-25 c-black"><?php echo $factureNonPayee." DH"?></span>
                            Montant des factures non payées 
                        </div>
                        <div class="box rad-10 b-solid txt-c p-20 c-gray">
                          <img src="../images/paid.png" alt="img5" >
                            <span class="d-block fw-bold mt-0 mb-5 fs-25 c-black"><?php echo $factureNonGenerer ?></span>
                            factures n'ont pas été générées                        
                        </div>
                        <div class="box rad-10 b-solid txt-c p-20 c-gray">
                        <img src="../images/reclam.png" alt="img2" >
                            <!-- <i class="fa-solid fa-spinner fa-2x mb-10 c-blue"></i> -->
                            <span class="d-block fw-bold mt-0 mb-5 fs-25 c-black"><?php echo $nbrReclamation ?></span>
                            Reclamations Non traitées
                        </div>
                    </div>
                </div>
<div class="welcome p-relative bg-white rad-10 text-c-mobile block-mobile p-20">
<div>
<canvas id="myChart"></canvas>
</div>         
  <script>  
    const labels = <?php echo json_encode($month) ?>;
    const data = {
      labels: labels,
      datasets: [{
        label: 'Consomation Par mois',
        data: <?php echo json_encode($consomation) ?>,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
          'rgb(255, 99, 132)',
          'rgb(255, 159, 64)',
          'rgb(255, 205, 86)',
          'rgb(75, 192, 192)',
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
          
        ],
        borderWidth: 1
      }]
    };

    const config = {
      type: 'bar',
      data: data,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      },
    };
    var myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>
</div>
<div class="welcome p-relative bg-white rad-10 text-c-mobile block-mobile p-20">
  <div>
    <canvas id="myChart2"></canvas>
  </div>         
  <script>  
    const labels2 = <?php echo json_encode($zone) ?>;
    const data2 = {
      labels: labels2,
      datasets: [{
        label: 'Consommation Par Zone',
        data: <?php echo json_encode($sumCon) ?>,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
          'rgb(255, 99, 132)',
          'rgb(255, 159, 64)',
          'rgb(255, 205, 86)',
          'rgb(75, 192, 192)',
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ],
        borderWidth: 1
      }]
    };

    const config2 = {
      type: 'bar',
      data: data2,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
    },
    };
    var myChart = new Chart(
      document.getElementById('myChart2'),
      config2
    );
  </script>
</div>
</div> 
</div>
</div>
</body>
</html>