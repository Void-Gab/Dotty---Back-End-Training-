<?php

/**
 * This is a DocBlock.
 */
class SimpleClass {
    /**
    * This is public
    */
    public $name;

    /**
    * Constructor
    */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
    * Method greet
    */
    public function greet() {
        return "Hello, my name is $this->name.";
    }

    /**
    * Method add
    */
    public function add($num1, $num2) {
        return $num1 + $num2;
    }

    /**
    * Method multi ply
    */
    public function multiply($num1, $num2) {
        return $num1 * $num2;
    }
}

// Create an instance of the class
$instance = new SimpleClass("John");

// Call methods
echo $instance->greet() . "\n"; // Output: Hello, my name is John.
echo $instance->add(5, 3) . "\n"; // Output: 8
echo $instance->multiply(2, 4) . "\n"; // Output: 8

?>
