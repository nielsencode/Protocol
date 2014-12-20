<?php

class Migrate {

    public static function export($data,$filename) {
        header('Content-type:text/csv');
        header("Content-disposition:attachment; filename=$filename.csv");

        $file = fopen('php://output','w');

        ob_clean();

        fputcsv($file,array_keys($data[0]));

        foreach($data as $datum) {
            fputcsv($file,$datum);
        }

        fclose($file);
    }

    public static function import($data,$template_path) {
        $data = csvToArray($data);

        if(empty($data)) {
            return false;
        }

        if(!isset($errors)) {
            $template = csvToArray(file_get_contents($template_path));
            $template_keys = array_keys($template[0]);

            if(!empty(array_diff(array_keys($data[0]),$template_keys))) {
                return false;
            }
        }

        return $data;
    }

    public static function template($template_path,$filename) {
        header('Content-type:text/csv');
        header("Content-disposition:attachment; filename='$filename.csv'");

        ob_clean();
        readfile($template_path);
    }

}