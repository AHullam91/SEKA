<?php
    include '../csatol/kapcsolat.php';
    session_start();
    
    if ( isset($_POST['azon']) && isset($_POST['jelszo']) ){
        $azon = $_POST['azon'];
        $jelszo = md5($_POST['jelszo']);
        $sql_admin = "SELECT * FROM admin WHERE azon = '$azon' AND jelszo = '$jelszo'";
        $keres = $conn->query($sql_admin);
        if ($keres->num_rows === 1){
            $_SESSION['admin'] = $azon;
        }
    }
    
    if (isset($_GET['kijelent'])){
        session_destroy();
    }
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title>Adminisztráció</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="admin_stilus.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container-fluid">
        <?php
            if(isset($_SESSION['admin'])){
?>
        <h2>Admin funkciók</h2>
        <p><a href="kutya_felvesz.php">Kutya felvétele</a></p>
        <p><a href="kutya_modosit.php">Kutya adatainak módosítása</a></p>
        <p><a href="cica_felvesz.php">Cica felvétele</a></p>
        <p><a href="cica_modosit.php">Cica adatainak módosítása</a></p>
        <p><a href="admin_kezel.php">Adminok kezelése</a></p>
        <p><a href="<?php print $_SERVER['PHP_SELF']; ?>?kijelent=1">Kijelentkezés</a></p>
        <p><a href="../index.php">Vissza a honlap főoldalára</a></p>
<?php                
            }
            else{
 ?>
        <h2>Bejelentkezés</h2>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <td>Azon: </td>
                    <td><input type="text" name="azon" size="20"></td>
                </tr>
                <tr>
                    <td>Jelszó: </td>
                    <td><input type="password" name="jelszo" size="20"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Bejelentkezés" name="be"></td>
                </tr>
            </table>
        </form>
 <?php
            }
        ?>
        </div>
    </body>
</html>
