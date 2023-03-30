<?php
    function korszamol($szul){
               
        $dateOfBirth = date("Y-m-d",$szul);
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        if ( $diff -> y > 1){
            return $diff->format('%y év %m hónap');
        }
        else{
            return $diff->format('%m hónap');
        }
        
    }

?>