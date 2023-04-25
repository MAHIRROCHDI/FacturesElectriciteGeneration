<?php 
session_start();
include("connexion.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['username'], $_POST['password'], $_POST['usertype'])) {
        $username = filter_input(INPUT_POST, 'username' );
        $password = filter_input(INPUT_POST, 'password');
        if ($_POST['usertype'] === "client") {
            $stmt = $conn->prepare("SELECT * FROM client WHERE cin = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                if (password_verify($password, $row['password'])) {
                    $_SESSION['client_id'] = $row['idClient'];
                    $_SESSION['client_nom'] = $row['nom'];
                    header("Location:client/acceuil.php");
                    exit(0);
                }
                else {
                    $message[] = 'Password Incorrect.';
                }
            }
            else {
                $message[] = 'usernam or password incorrect!';
            }
    
        }
        else if ($_POST['usertype'] === "admin") {
            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                if (password_verify($password, $row['password'])) {
                    $_SESSION['admin_id'] = $row['idAdmin'];
                    header("Location:admin/dashboard.php");
                    exit(0);
                }
                else {
                    $message[] = 'Password Incorrect.';
                }
            }  
            else {
                $message[] = 'usernam or password incorrect!'; 
            }         
        }
        else {
            $stmt = $conn->prepare("SELECT * FROM agent WHERE numeroAgent = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                if ($password === $row['password']) {
                    $_SESSION['agent_id'] = $row['idAgent'];
                    $_SESSION['agent_num'] = $row['numeroAgent'];
                    header("Location:admin/agent.php");  
                    exit(0);
                }
                else {
                    $message[] = 'Password Incorrect.';
                }
            }
            else {
                $message[] = 'usernam or password incorrect!';
            }
            
        }
    }
}
?>
<?php include("component/head.php") ?>
<body>
    <?php include("component/header.php") ?>
    <div class="container">
                    <?php
                        if(isset($message)){
                            foreach($message as $msg) {
                                echo '<div class = "message" >'.$msg.'</div>' ; 
                            }
                        } 
                    ?>
        <form class="login" action="" method="POST">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="username">
            <input type="password" name = "password" placeholder="password">
            <select name="usertype">
                <option value="admin">Admin</option>
                <option value="client">Client</option>
                <option value="agent">Agent</option>
            </select>
            <input type="submit" value="Login">
        </form>
    </div>
</body>