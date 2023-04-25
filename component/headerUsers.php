<!-- start head -->
<div class="head bg-white p-15 between-flex">
    <div class="search p-relative">
        <input class="p-10 rad-10 b-solid" type="search" placeholder="Type A keyword">
    </div>
    <div class="icons d-flex df-align-center">
        <span class="notification p-relative"> 
            <i class="fa-regular fa-bell fa-lg"></i>
        </span>
        <img src="../images/<?php echo isset($_SESSION['client_id']) ? "team-03.png" :"team-01.png" ;?>." alt="avatar">
    </div>
</div>
<!-- end head -->