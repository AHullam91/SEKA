<?php
    include 'csatol/kapcsolat.php';
    include 'kor.php';
?>

<!DOCTYPE html>

<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title>Cicáink</title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="stilus.css" rel="stylesheet" type="text/css"/>
</head>
    <body>
        
<?php
    include 'menu.html';
    if(!isset($_GET['index'])){
        $cica_sql = "SELECT * FROM macska WHERE not gazdis ORDER BY felveve DESC";
        $cica_keres = $conn -> query($cica_sql);
?>
        <header>
            <img class="mx-auto d-block" src="kepek/header12.jpg">
        </header> 
        <div id="kiskepek" class="container-fluid">        
<?php
        while($cica = $cica_keres -> fetch_assoc()){
            $cica_id = $cica['id'];
            $cica_neve = $cica['neve'];
?>
            <div class="row sor">
                <h2><?php echo $cica_neve ?></h2>
                <div class="col-lg-8">
<?php
            $kep_sql = "SELECT * FROM macska_kepek WHERE macska_azon = '$cica_id'";
            $kep_keres = $conn -> query($kep_sql);
            while($kep = $kep_keres -> fetch_assoc()){
                $eleres = "kepek/cica/" . $cica_neve . "/" . $kep['neve'];
                $kepTomb[] = $eleres;
            }
            for($i = 0; $i < count($kepTomb); $i++){
?>
                    <a href="<?php print $_SERVER['PHP_SELF']; ?>?index=<?php echo $i ?>&cica_id=<?php echo $cica_id ?>"><img src="<?php echo $kepTomb[$i] ?>" class="img-thumbnail"></a>
<?php                
            }
            unset($kepTomb);
?>                    
                </div>
                <div class="col-lg-4">
                    <table class="table-striped">
                        <tr>
                            <td class="fk">Neme: </td>
                            <td>
<?php
            if($cica['ivar']){
                echo 'kandúr';
            }
            else{
                echo 'nőstény';
            }
?>                                
                            </td>
                        </tr>
                        <tr>
                            <td class="fk">Kora: </td>
                            <td>
<?php
            echo korszamol($cica['szuletett']);
?>                            
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
<?php
            if (!$cica['ivartalanitva']){
                echo 'A cica csak ivartalanítási kötelezettség vállalásával fogadható örökbe!!!';
            }
?>                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $cica['egyeb'] ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
<?php            
        }
?>            
        </div>
<?php
        }
        else{
            $i = $_GET['index'];
            $cica_id = $_GET['cica_id'];
            
            $cica_sql = "SELECT * FROM macska WHERE id = '$cica_id'";
            $cica_keres = $conn -> query($cica_sql);
            $cica = $cica_keres -> fetch_assoc();
            $cica_neve = $cica['neve'];
            
            $kep_sql = "SELECT * FROM macska_kepek WHERE macska_azon = '$cica_id'";
            $kep_keres = $conn -> query($kep_sql);
            while($kep = $kep_keres -> fetch_assoc()){
                $eleres = "kepek/cica/" . $cica_neve . "/" . $kep['neve'];
                $kepTomb[] = $eleres;
            }
            $max = count($kepTomb) - 1;
            
            $kepteljes = "kepek/cica/" . $cica_neve . "/" . $i+1;
?>
        <div class="container-fluid" id="nagykep">
            <table class="table-borderless table-sm">
                    <tr>
                        <td class="lapoz">&nbsp;</td>
                        <td class="cim"><?php echo $cica_neve . " : " . $i+1 . "/" . count($kepTomb) ?></td>
                        <td class="lapoz cim"><a href="<?php print $_SERVER['PHP_SELF']; ?>">X</a></td>
                    </tr>
                    <tr>
                        <td class="cim">
<?php
    if ($i > 0){
        $ujSorszam = $i - 1;
    }
    else {
        $ujSorszam = $max;
    }
?>
                        <a href="<?php print $_SERVER['PHP_SELF']; ?>?index=<?php echo $ujSorszam ?>&cica_id=<?php echo $cica_id ?>">&laquo;</a>                            
                        </td>
                        <td class="kepNagy">
                            <img class="img-fluid" src="<?php echo $kepTomb[$i] ?>">
                        </td>
                        <td class="cim">
<?php
    if ($i < $max){
        $ujSorszam = $i + 1;
    }
    else {
        $ujSorszam = 1;
    }
?>
                        <a href="<?php print $_SERVER['PHP_SELF']; ?>?index=<?php echo $ujSorszam ?>&cica_id=<?php echo $cica_id ?>">&raquo;</a>                            
                        </td>
                    </tr>
                </table>
        </div>    
<?php            
        }
?>        
    </body>
</html>
