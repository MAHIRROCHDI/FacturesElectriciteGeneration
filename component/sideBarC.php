<div class="sidebar p-20 bg-white p-relative">
        <h3 class="p-relative txt-c mt-0"> <?php echo $_SESSION['client_nom'] ?></h3>
        <ul>
            <li>
                <a class="active d-flex df-align-center fs-14 c-black rad-6 p-10" href="acceuil.php">
                    <i class="fa-regular fa-chart-bar fa-fw"></i>
                    <span class="hide-in-mobile">Acceuil</span>
                </a>
            </li>
            <li>
                <a class="d-flex df-align-center fs-14 c-black rad-6 p-10" href="consomation.php">
                    <i class="fa-solid fa-pen"></i>
                    <span class="hide-mobile">Saisir Consommation</span>
                </a>
            </li>
            <li>
                <a class="d-flex df-align-center fs-14 c-black rad-6 p-10" href="factures.php">
                    <i class="fa-solid fa-receipt"></i>
                    <span class="hide-mobile">Voir Factures</span>
                </a>
            </li>
            <li>
                <a class="d-flex df-align-center fs-14 c-black rad-6 p-10" href="dernRec.php">
                <i class="fa-solid fa-circle-exclamation"></i>
                    <span class="hide-mobile">Reclamation</span>
                </a>
            </li>
            <li>
                <a class="d-flex df-align-center fs-14 c-black rad-6 p-10" href="../logoutClient.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="hide-mobile">Deconnecter</span>
                </a>
            </li>
        </ul>
</div>