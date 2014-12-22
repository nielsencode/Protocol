<?php

class Migrate {

    protected $errors = array();

    protected $data;

    public function fails() {
        return !empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }

    public function data() {
        return $this->data;
    }

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
        $migrate = new self;

        $data = csvToArray($data);

        if(empty($data)) {
            $migrate->errors[] = "Could not import data. File contains no data.";
        }

        $template = csvToArray(file_get_contents($template_path));

        $diff = array_diff_key($template[0],$data[0]);

        if(!empty($diff)) {
            $migrate->errors[] = "Could not import data. File is missing one or more keys.";
        }

        if(!$migrate->fails()) {
            $migrate->data = $data;
        }

        return $migrate;
    }

    public static function template($template_path,$filename) {
        header('Content-type:text/csv');
        header("Content-disposition:attachment; filename='$filename.csv'");

        ob_clean();
        readfile($template_path);
    }

}