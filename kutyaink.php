<?php
    include 'csatol/kapcsolat.php';
    include 'kor.php';
?>

<!DOCTYPE html>

<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title>Kutyáink</title>
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
        $kutya_sql = "SELECT * FROM kutya WHERE not gazdis ORDER BY felveve DESC";
        $kutya_keres = $conn -> query($kutya_sql);
?>
        <header>
             <img class="mx-auto d-block" src="kepek/header12.jpg">
        </header> 
        <div id="kiskepek" class="container-fluid">        
<?php
        while($kutya = $kutya_keres -> fetch_assoc()){
            $kutya_id = $kutya['id'];
            $kutya_neve = $kutya['neve'];
?>
            <div class="row sor">
                <h2><?php echo $kutya_neve ?></h2>
                <div class="col-lg-8">
<?php
            $kep_sql = "SELECT * FROM kutya_kepek WHERE kutya_id = '$kutya_id'";
            $kep_keres = $conn -> query($kep_sql);
            while($kep = $kep_keres -> fetch_assoc()){
                $eleres = "kepek/kutya/" . $kutya_neve . "/" . $kep['neve'];
                $kepTomb[] = $eleres;
            }
            for($i = 0; $i < count($kepTomb); $i++){
?>
                    <a href="<?php print $_SERVER['PHP_SELF']; ?>?index=<?php echo $i ?>&kutya_id=<?php echo $kutya_id ?>"><img src="<?php echo $kepTomb[$i] ?>" class="img-thumbnail"></a>
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
            if($kutya['ivar']){
                echo 'kan';
            }
            else{
                echo 'szuka';
            }
?>                                
                            </td>
                        </tr>
                        <tr>
                            <td class="fk">Kora: </td>
                            <td>
<?php
            echo korszamol($kutya['szuletett']);
?>                            
                            </td>
                        </tr>
                        <tr>
                            <td class="fk">Testmérete: </td>
                            <td><?php echo $kutya['merete'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
<?php
            if (!$kutya['ivartalanitva']){
                echo 'A kutya csak ivartalanítási kötelezettség vállalásával fogadható örökbe!!!';
            }
?>                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $kutya['egyeb'] ?>
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
            $kutya_id = $_GET['kutya_id'];
            
            $kutya_sql = "SELECT * FROM kutya WHERE id = '$kutya_id'";
            $kutya_keres = $conn -> query($kutya_sql);
            $kutya = $kutya_keres -> fetch_assoc();
            $kutya_neve = $kutya['neve'];
            
            $kep_sql = "SELECT * FROM kutya_kepek WHERE kutya_id = '$kutya_id'";
            $kep_keres = $conn -> query($kep_sql);
            while($kep = $kep_keres -> fetch_assoc()){
                $eleres = "kepek/kutya/" . $kutya_neve . "/" . $kep['neve'];
                $kepTomb[] = $eleres;
            }
            $max = count($kepTomb) - 1;
            
            $kepteljes = "kepek/kutya/" . $kutya_neve . "/" . $i+1;
?>
        <div class="container-fluid" id="nagykep">
            <table class="table-borderless table-sm">
                    <tr>
                        <td class="lapoz">&nbsp;</td>
                        <td class="cim"><?php echo $kutya_neve . " : " . $i+1 . "/" . count($kepTomb) ?></td>
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
                        <a href="<?php print $_SERVER['PHP_SELF']; ?>?index=<?php echo $ujSorszam ?>&kutya_id=<?php echo $kutya_id ?>">&laquo;</a>                            
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
                        <a href="<?php print $_SERVER['PHP_SELF']; ?>?index=<?php echo $ujSorszam ?>&kutya_id=<?php echo $kutya_id ?>">&raquo;</a>                            
                        </td>
                    </tr>
                </table>
        </div>    
<?php            
        }
?>        
    </body>
</html>
