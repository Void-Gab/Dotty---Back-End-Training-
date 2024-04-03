<?php


class DBConnection {

    private function __construct() {
        echo "New object created \n";
    }

    public static function getInstance() {

        static $instance = null;

        if (null == $instance) {
            $instance = new static();
        } else {
            echo "Using same object \n";
        }

        return $instance;
    }
}