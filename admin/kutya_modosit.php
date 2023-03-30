<?php
    include '../csatol/kapcsolat.php';
    session_start();
    if (!isset($_SESSION['admin'])) header("Location: ../index.php");
    
    if(isset($_POST['valaszt']) && $_POST['kutya_valaszt'] > 0){ //ha kiválasztottak egy kutyát a listából
        $kutya_id = $_POST['kutya_valaszt'];
        $sql = "SELECT * FROM kutya WHERE id = '$kutya_id'";
        $result = $conn -> query($sql);
        $kutya = $result -> fetch_assoc();
    }
    
    if (isset($_POST['ment'])){
        $id = $_POST['id'];
        $nev = $_POST['nev_uj'];
        $ivar = $_POST['ivar_uj'];
        $szuletett = mktime(0,0,0,$_POST['ho_uj'], $_POST['nap_uj'], $_POST['ev_uj']);
        if($_POST['meret_uj'] == 1) $meret = "kicsi";
            elseif($_POST['meret_uj'] == 2) $meret = "közepes";
            else $meret = "nagy";
        if(isset($_POST['ivaros_uj'])){
            $ivartalanitva = $_POST['ivaros_uj'];
            $sql = "UPDATE kutya SET ivartalanitva = '$ivartalanitva' WHERE id = '$id'";
            $result = $conn -> query($sql);
        }
        if(isset($_POST['gazdis_uj'])){
            $gazdis = $_POST['gazdis_uj'];
            $sql = "UPDATE kutya SET gazdis = '$gazdis' WHERE id = '$id'";
            $result = $conn -> query($sql);
        }
        if(isset( $_POST['ho_gazdi']) && isset($_POST['nap_gazdi']) && isset($_POST['ev_gazdi']) ){
            $gazdihoz = mktime(0,0,0,$_POST['ho_gazdi'], $_POST['nap_gazdi'], $_POST['ev_gazdi']);
            $sql = "UPDATE kutya SET gazdihoz = '$gazdihoz' WHERE id = '$id'";
        $result = $conn -> query($sql);
        }
        $leiras = $_POST['leiras_uj'];
        
        $sql = "UPDATE kutya SET neve = '$nev', ivar = '$ivar', szuletett = '$szuletett', merete = '$meret', egyeb = '$leiras' WHERE id = '$id'";
        $result = $conn -> query($sql);
        if($result){
            $uzen = "A kutya adatainak módosítása sikeres.";
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
        <title>Kutya adatainak módosítása</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="admin_stilus.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container-fluid">
        <h1>Kutya adatainak módosítása</h1>
<?php
    if(isset($kutya)){
?>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <td>Neve: </td>
                    <td><input type="text" name="nev_uj" size="30" value='<?php echo $kutya['neve'] ?>'></td>
                </tr>
                <tr>
                    <td>Ivara: </td>
                    <td>
                        Szuka: <input type="radio" name="ivar_uj" value="0" <?php if($kutya['ivar'] == 0) echo 'checked' ?>> &nbsp; 
                        Kan: <input type="radio" name="ivar_uj" value="1" <?php if($kutya['ivar'] == 1) echo 'checked' ?>>
                    </td>
                </tr>
                <tr>
                    <td>Született: </td>
                    <td>
                        Év: <input type="number" name="ev_uj" value="<?php echo date('Y', $kutya['szuletett']) ?>"> 
                        Hónap: <input type="number" name="ho_uj" value="<?php echo date('m', $kutya['szuletett']) ?>"> 
                        Nap: <input type="number" name="nap_uj" value="<?php echo date('d', $kutya['szuletett']) ?>"> 
                    </td>
                </tr>
                <tr>
                    <td>Mérete: </td>
                    <td>
                        <select name="meret_uj">
                            <option value="1" <?php if($kutya['merete'] == "kicsi") echo 'selected' ?>>kicsi</option>
                            <option value="2" <?php if($kutya['merete'] == "közepes") echo 'selected' ?>>közepes</option>
                            <option value="3" <?php if($kutya['merete'] == "nagy") echo 'selected' ?>>nagy</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Ivartalanitva: </td>
                    <td><input type="checkbox" name="ivaros_uj" value="1" <?php if($kutya['ivartalanitva']) echo 'checked'; ?>></td>
                </tr>
                <tr>
                    <td>Gazdis: </td>
                    <td><input type="checkbox" name="gazdis_uj" value="1" <?php if($kutya['gazdis']) echo 'checked'; ?>></td>
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
                        <textarea name="leiras_uj" cols="50" rows="3"><?php echo $kutya['egyeb'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $kutya_id ?>">
                        <input type="submit" name="ment" value="Mentés">
                    </td>
                </tr>
            </table>
        </form>
<?php        
    }
    else{
        $sql = "SELECT * FROM kutya";
        $result = $conn -> query($sql);
?>
            <h2>Kutya kiválasztása</h2>
            <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
                <select name="kutya_valaszt">
                    <option value="0">kutya kiválasztása</option>
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
