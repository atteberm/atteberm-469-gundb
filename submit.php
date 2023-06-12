<?php
    error_reporting(E_ALL);
    if(isset($_POST)) {
        if(isset($_POST['csv'])) {
            $resCSV = json_decode($_POST['csv']);
            $csvType = json_decode(($_POST['flag']));
            $msg = $csvType.$resCSV[0][0];
            echo $resCSV[0][0];

            $fp = fopen($csvType, 'w');
            foreach($resCSV as $fields) {
                fputcsv($fp, $fields);
            }
            fclose($fp);
        }
    }
?>