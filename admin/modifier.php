<?php 
require("../connexion.php") ; 
session_start() ; 
if(!isset($_SESSION['admin_id'])){
    header("Location:../login.php") ; 
    exit(0) ;
}
if(isset($_POST['modifier'])) {
    $id = $conn->real_escape_string($_POST['id']) ; 
    $name = $conn->real_escape_string($_POST['name']) ; 
    $cin = $conn->real_escape_string($_POST['cin']) ; 
    $prenom = $conn->real_escape_string($_POST['prenom']) ; 
    $address = $conn->real_escape_string($_POST['address']) ;
    $zone = $conn->real_escape_string($_POST['zone_id']) ; 
    $pass = $conn->real_escape_string(password_hash($_POST['pass'] , PASSWORD_DEFAULT)) ; 
    $sql = "UPDATE client SET cin = '$cin' , nom = '$name', prenom = '$prenom', address = '$address', zone_geo = '$zone', password ='$pass'  WHERE idClient = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $message[] = 'Client information updated successfully.';
    } else {
        $message[] = 'Error updating client information: ' . mysqli_error($conn);
    }
}
$id =$conn->real_escape_string($_GET['id']);
$sql = "SELECT * FROM client WHERE idClient = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
} 
?>

<?php 
    $title = "Modifier Client" ; 
    include('../component/headA.php')
?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarA.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Modifier Client</h1>
            <div class="Quick-draft p-20 bg-white rad-10 m-20">
                    <?php
                        if(isset($message)){
                            foreach($message as $msg) {
                                echo '<div class = "message" >'.$msg.'</div>' ; 
                            }
                        } 
                    ?>
                <h2 class="mt-0 mb-10">Monsieur <?php echo $row['nom']." ".$row['prenom'] ?></h2>
                <p class="mt-0 mb-20 c-gray fs-15">Modifier les donnees de <?php echo $row['nom'] ?></p>
                <form action="" method="post">
                    <input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="hidden" name="id" value="<?php echo $row['idClient']?>">
                    Nom : <input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="text" name="name" value= "<?php echo $row['nom']?>" >
                    Prenom :<input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="text" name="prenom" value= "<?php echo $row['prenom']?>" >
                    CIN : <input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="text" name="cin" value= "<?php echo $row['cin']?>" >
                    Address :<input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="text" name="address" value= "<?php echo $row['address']?>"  >
                    Zone : <select class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" name="zone_id">
                        <?php 
                            $sql = "SELECT * FROM zonegeographique"; 
                            $result = mysqli_query($conn , $sql) ; 
                            while ($zone = mysqli_fetch_assoc($result)) {
                                    $selected = ($zone['idZone'] == $row['zone_geo']) ? 'selected' : '';
                                    echo "<option value='{$zone['idZone']}' $selected>{$zone['nomZone']}</option>";
                            }
                        ?>
                    </select>
                    Password :<input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="password" name="pass" value= "<?php echo $row['password']?>" >
                    <input class="save d-block fs-14 bg-blue c-white b-none w-fit btn-shape" type="submit" name="modifier" value="Modifier">
                </form>
            </div>
    </div>
</body>
</html>
