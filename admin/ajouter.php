<?php 
require("../connexion.php") ; 
session_start() ; 
if(!isset($_SESSION['admin_id'])){
    header("Location:../login.php") ; 
    exit(0) ;
}
    if(isset($_POST['ajouter'])) {
        $name = $conn->real_escape_string($_POST['name']) ; 
        $prenom = $conn->real_escape_string($_POST['prenom']) ;
        $cin = $conn->real_escape_string($_POST['cin']) ;  
        $address = $conn->real_escape_string($_POST['address']) ;
        $zone = $conn->real_escape_string($_POST['zone_id']) ; 
        $pass =password_hash($_POST['pass'] , PASSWORD_DEFAULT) ; 
        $select = mysqli_query($conn , "SELECT * FROM client WHERE cin = '$cin'") ; 
        if(mysqli_num_rows($select) > 0) {
            $message[] = 'Client deja exist!' ; 
        }
        else {
            $sql = "INSERT INTO client(cin ,nom , prenom ,password,address,zone_geo) VALUES('$cin' , '$name' , '$prenom' , '$pass', '$address' , '$zone')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $message[] = 'Client Ajouter avec Succee' ;
            } else {
                $message[] = 'Echec D\'ajout du Client!!' ;
            }
        }
    }
?>


<?php 
    $title = "Ajouter Client" ; 
    include('../component/headA.php')
?>
<body>
    <div class="page d-flex">
        <?php include("../component/sideBarA.php")?>
        <div class="content w-full">
            <?php include("../component/headerUsers.php")?>
            <h1 class="p-relative">Ajouter Client</h1>
            <div class="Quick-draft p-20 bg-white rad-10 m-20">
                <p class="mt-0 mb-20 c-gray fs-15">Ajouter les Infos de client</p>
                <?php
                    if(isset($message)){
                        foreach($message as $msg) {
                            echo '<div class = "message" >'.$msg.'</div>' ; 
                        }
                    } 
                ?>
                <form action="" method="post">
                    Nom : <input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="text" name="name" >
                    Prenom :<input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="text" name="prenom">
                    CIN :<input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="text" name="cin">
                    Address :<input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="text" name="address">
                    Zone : <select class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" name="zone_id">
                        <?php 
                            $sql = "SELECT * FROM zonegeographique"; 
                            $result = mysqli_query($conn , $sql) ; 
                            while ($zone = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$zone['idZone']}' selected>{$zone['nomZone']}</option>";
                            }
                        ?>
                    </select>
                    Password :<input class="d-block mb-20 w-full bg-eee b-none p-10 rad-6" type="password" name="pass">
                    <input class="save d-block fs-14 bg-blue c-white b-none w-fit btn-shape" type="submit" name="ajouter" value="Ajouter">
                </form>
            </div>
    </div>
</body>
</html>