<?php
    include '../csatol/kapcsolat.php';
    session_start();
    if (!isset($_SESSION['admin'])) header("Location: ../index.php");
    
    if(isset($_POST['cica_valaszt'])){
        $cica_id = $_POST['cica_valaszt'];
        $sql = "SELECT * FROM macska WHERE id = '$cica_id'";
        $result = $conn -> query($sql);
        $cica = $result -> fetch_assoc();
        
        $_SESSION['cica_neve'] = $cica['neve'];
        $_SESSION['cica_id'] = $cica['id'];
    }
    
    if(isset($_POST['ment'])){
        $neve = $_POST['cica_neve'];
        //a cica neve nem szerepelhet kétszer az adatbázisban
        $sql = "SELECT * FROM macska WHERE neve = '$neve'";
        $result = $conn -> query($sql);
        if($result -> num_rows > 0) $uzen = "Ez a név már szerepel az adatbázisban";
        else {
            $konyvtar = "../kepek/cica/" . $neve;
            $konyvtar = mb_convert_encoding($konyvtar, "ISO-8859-2", "UTF-8");
            if (!mkdir($konyvtar, 0777, true)) {  //a képek mappában létrehozza a cica saját mappáját
                $uzenet = "Hiba történt a fájl feltöltésekor.";
            }
            else {           
                $szuletett = mktime(0,0,0,$_POST['ho'], $_POST['nap'], $_POST['ev']);
                $cica_ivar = $_POST['ivar'];
                if($cica_ivar == 0) $ivar = false;
                else $ivar = true;
                $leiras = $_POST['leiras'];
                $felveve = time();
                $admin_azon = $_SESSION['admin'];

                $sql = "INSERT INTO macska (neve, ivar, szuletett, felveve,  egyeb, admin_azon) VALUES ('$neve', '$ivar', '$szuletett', '$felveve', '$leiras', '$admin_azon')";
                $result = $conn -> query($sql);
                $id = $conn -> insert_id;
                if ($result){
                    $uzen = "A cica felvétele sikeres.";
                    $_SESSION['cica_neve'] = $neve;
                    $_SESSION['cica_id'] = $id;
                }
            }    
        }
    }
    
    if(isset($_GET['masik'])){
        unset($_SESSION['cica_neve']);
        unset($_SESSION['cica_id']);
    }
    
    if (isset($_POST['feltolt'])){
        $target= "../kepek/cica/" . $_SESSION['cica_neve'] . "/"; //célmappa
        $target = mb_convert_encoding($target, "ISO-8859-2", "UTF-8");
        $file_name = $_FILES['file']['name']; //a célfájlt nevezze el a $_FILES superglobal változóban lévo fájlnévre (a fájl eredeti nevére)
        $file_name_kodolt = mb_convert_encoding($file_name, "ISO-8859-2", "UTF-8");
        
        $tmp_dir = $_FILES['file']['tmp_name']; //az ideiglenes mappa helyét a $tmp_dir változóban tároljuk

        if(!preg_match('/(gif|jpe?g|png)$/i', $file_name)) //ha a fájlnak ($file_name-nek) a kiterjesztése nem gif, jpg/jpeg, png, akkor...
        {
            $uzenet = "Rossz fajltipus!"; //hibaüzenet
        }
        else {
            $cica_id = $_SESSION['cica_id'];
            $sql = "SELECT * FROM macska_kepek WHERE neve = '$file_name' and macska_azon = '$cica_id'";
            $result = $conn->query($sql);
            if ( $result -> num_rows > 0) {
                $uzenet = "Ezzel a fáljnévvel már van kép a könyvtárban";
            }
            else {
                $feltolt = move_uploaded_file($tmp_dir, $target . $file_name_kodolt); //az ideiglenes mappából átteszi a fájlt a végleges mappába (a $target . $file_name összeilleszti a két stringet, így uploads/fajlnev-et kapunk)
                if ($feltolt){

                    $sql = "INSERT INTO macska_kepek (neve, macska_azon) VALUES ('$file_name', '$cica_id')";
                    $result = $conn->query($sql);
                    if ($result){
                        $uzen = "A kép feltöltve. " . $file_name;
                    }
                    else {
                        $uzen = "A kép feltöltve, de az adatbázisba töltés sikertelen. Próbálja újra.";
                    }
                }
                else {
                    $uzen = "A képfájl feltöltése nem sikerült.";
                    unset($file_name);
                }
            }
        }    
    }
    
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title>Cica rögzítése</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="admin_stilus.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container-fluid">
<?php
    if(!isset($_SESSION['cica_id'])){  //ha még nem mentették a cica adatait
        $sql = "SELECT * FROM macska";
        $result = $conn -> query($sql);
?>
        <h2>Adatok felvétele</h2>
        <p>
            Ha már rögzített cicához szeretne képet feltölteni, válassza ki a cica nevét az alábbi lenyíló listából:
        </p>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
            <select name="cica_valaszt">
                <option>cica kiválasztása</option>
<?php
        while($egy = $result -> fetch_assoc()){
?>
                <option value="<?php echo $egy['id'] ?>"><?php echo $egy['neve'] ?></option>
<?php                
        }
?>                
            </select>
            <input type="submit" value="Kiválasztom">
        </form>
        <h2>Új cica felvétele</h2>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
            <table>
                <tr>
                    <td>neve:</td>
                    <td><input type="text" name="cica_neve" size="25"></td>
                </tr>
                <tr>
                    <td>születési dátum:</td>
                    <td>
                        év: <input type="number" size="4" name="ev" id="ev"> 
                        hónap: <input type="number" size="2" name="ho" id="ho"> 
                        nap: <input type="number" size="2" name="nap" id="nap">
                    </td>
                </tr>
                <tr>
                    <td>ivar:</td>
                    <td>
                        nőstény: <input type="radio" name="ivar" value="0"> &nbsp; &nbsp; &nbsp; kandúr: <input type="radio" name="ivar" value="1">
                    </td>
                </tr>
                <tr>
                    <td>leírás</td>
                    <td><textarea name="leiras" cols="50" rows="3" maxlength="180"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="ment" value="Elmentem" onclick="datumellenoriz()"></td>
                </tr>
            </table>
        </form>
<?php
    }
    else{ // képek feltöltése
?>
            <h2>Képek feltöltése</h2>
            <h3><?php echo $_SESSION['cica_neve'] ?></h3>
            <form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> <!--a feltöltött file maximális mérete 2mb-->
                <input id="file" type="file" name="file">
                <input type="submit" name="feltolt" value="Feltöltöm">
            </form>
<?php        
    }
?>
            <p><a href="<?php print $_SERVER['PHP_SELF']; ?>?masik=1">Másik cica felvétele</a></p>
            <p id="uzen"><?php if (isset($uzen)) echo $uzen?></p>
            <p><a href="index.php">Vissza a főoldalra</a></p>
            <p><a href="../index.php">A honlap főoldalára</a></p>
        </div>
    </body>
</html>
