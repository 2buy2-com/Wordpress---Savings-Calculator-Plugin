<?php 

class Savings_Calculator_Custom_Settings {

    public $categories;

    public function __construct(){
        $this->categories = $this->generateCategories();
    }

    public function generateCategories(){
        return array(
            'Office Supplies',
            'Photocopiers',
            'Water',
            'Telecoms'
        );
    }
}
