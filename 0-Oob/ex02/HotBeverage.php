<?php 
    class HotBeverage {
        const nom = "HotBeverage";
        const price = 1.50;
        const resistance = 50;

        public function getName() {
            return self::nom;
        }

        public function getPrice() {
            return self::price;
        }

        public function getResistence() {
            return self::resistance;
        }
    }
?>