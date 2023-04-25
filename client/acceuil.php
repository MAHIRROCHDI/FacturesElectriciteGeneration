<?php 
require("../connexion.php") ; 
session_start(); 
if(!isset($_SESSION['client_id'])){
    header("Location:../login.php") ;
    exit(0) ;  
} ; 
$id_client = $_SESSION['client_id'] ; 
$query = mysqli_query($conn , "SELECT consomationMensuel , mois FROM facture WHERE idClient = '$id_client' group by mois") ; 
foreach($query as $data){
    $month[] = $data['mois'] ; 
    $consomation[] = $data['consomationMensuel'] ;
}
?>
<?php 
    $title = "Acceuil Client" ; 
    include '../component/headA.php' ; 
 ?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarC.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Acceuil</h1>
            <!-- start wrapper -->
            <div class="wrapper d-grid gap-20">
            <div class="tickets bg-white rad-10 p-20">
                    <p class="mt-0 mb-20 c-gray fs-15"></p>
                    <div class="boxs gap-20">
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
                </div>
            </div>
        </div>
    </div>
</body>
</htm>
