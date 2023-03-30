<?php
    include '../csatol/kapcsolat.php';
    session_start();
    if (!isset($_SESSION['admin'])) header("Location: ../index.php");
    
    if(isset($_POST['valaszt']) && $_POST['cica_valaszt'] > 0){ //ha kiválasztottak egy kutyát a listából
        $cica_id = $_POST['cica_valaszt'];
        $sql = "SELECT * FROM macska WHERE id = '$cica_id'";
        $result = $conn -> query($sql);
        $cica = $result -> fetch_assoc();
    }
    
    if (isset($_POST['ment'])){
        $id = $_POST['id'];
        $nev = $_POST['nev_uj'];
        $ivar = $_POST['ivar_uj'];
        $szuletett = mktime(0,0,0,$_POST['ho_uj'], $_POST['nap_uj'], $_POST['ev_uj']);
        if(isset($_POST['ivaros_uj'])){
            $ivartalanitva = $_POST['ivaros_uj'];
            $sql = "UPDATE macska SET ivartalanitva = '$ivartalanitva' WHERE id = '$id'";
            $result = $conn -> query($sql);
        }
        if(isset($_POST['gazdis_uj'])){
            $gazdis = $_POST['gazdis_uj'];
            $sql = "UPDATE macska SET gazdis = '$gazdis' WHERE id = '$id'";
            $result = $conn -> query($sql);
        }
        $gazdihoz = mktime(0,0,0,$_POST['ho_gazdi'], $_POST['nap_gazdi'], $_POST['ev_gazdi']);
        $leiras = $_POST['leiras_uj'];
        
        $sql = "UPDATE macska SET neve = '$nev', ivar = '$ivar', szuletett = '$szuletett', gazdihoz = '$gazdihoz', egyeb = '$leiras' WHERE id = '$id'";
        $result = $conn -> query($sql);
        if($result){
            $uzen = "A cica adatainak módosítása sikeres.";
        }
        else{
            $uzen = "Nem sikerült az adatok módosítása.";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title>Cica adatainak módosítása</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="admin_stilus.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container-fluid">
        <h1>Cica adatainak módosítása</h1>
<?php
    if(isset($cica)){
?>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <td>Neve: </td>
                    <td><input type="text" name="nev_uj" size="30" value='<?php echo $cica['neve'] ?>'></td>
                </tr>
                <tr>
                    <td>Ivara: </td>
                    <td>
                        Nőstény: <input type="radio" name="ivar_uj" value="0" <?php if($cica['ivar'] == 0) echo 'checked' ?>> &nbsp; 
                        Kandúr: <input type="radio" name="ivar_uj" value="1" <?php if($cica['ivar'] == 1) echo 'checked' ?>>
                    </td>
                </tr>
                <tr>
                    <td>Született: </td>
                    <td>
                        Év: <input type="number" name="ev_uj" value="<?php echo date('Y', $cica['szuletett']) ?>"> 
                        Hónap: <input type="number" name="ho_uj" value="<?php echo date('m', $cica['szuletett']) ?>"> 
                        Nap: <input type="number" name="nap_uj" value="<?php echo date('d', $cica['szuletett']) ?>"> 
                    </td>
                </tr>
                <tr>
                    <td>Ivartalanitva: </td>
                    <td><input type="checkbox" name="ivaros_uj" value="1" <?php if($cica['ivartalanitva']) echo 'checked'; ?>></td>
                </tr>
                <tr>
                    <td>Gazdis: </td>
                    <td><input type="checkbox" name="gazdis_uj" value="1" <?php if($cica['gazdis']) echo 'checked'; ?>></td>
                </tr>
                <tr>
                    <td>Gazdihoz kerül: </td>
                    <td>
                        Év: <input type="number" name="ev_gazdi" value="0"> 
                        Hónap: <input type="number" name="ho_gazdi" value="0"> 
                        Nap: <input type="number" name="nap_gazdi" value="0"> 
                    </td>
                </tr>
                <tr>
                    <td>Leírás: </td>
                    <td>
                        <textarea name="leiras_uj" cols="50" rows="3"><?php echo $cica['egyeb'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $cica_id ?>">
                        <input type="submit" name="ment" value="Mentés">
                    </td>
                </tr>
            </table>
        </form>
<?php        
    }
    else{
        $sql = "SELECT * FROM macska";
        $result = $conn -> query($sql);
?>
        <h2>Cica kiválasztása</h2>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
            <select name="cica_valaszt">
                <option value="0">cica kiválasztása</option>
<?php
        while($egy = $result -> fetch_assoc()){
?>
                <option value="<?php echo $egy['id'] ?>"><?php echo $egy['neve'] ?></option>
<?php                
        }
?>                
            </select>
            <input type="submit" value="Kiválasztom" name="valaszt">
        </form>
<?php        
    }
?>
        <p id="uzen"><?php if(isset($uzen)) echo $uzen; ?></p>
        <p><a href="index.php">Vissza a főoldalra</a></p>
        <p><a href="../index.php">A honlap főoldalára</a></p>
        </div>
    </body>
</html>
