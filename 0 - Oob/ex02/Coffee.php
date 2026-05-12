<?php
    require_once ("HotBeverage.php");

    class Coffee extends HotBeverage {
        const nom = "Coffee";
        const price = 1.5;
        const resistance = 5;
        private $description = "Coffee is a beverage brewed from roasted, 
                                ground coffee beans. Darkly colored, bitter, 
                                and slightly acidic, coffee has a stimulating effect on humans, 
                                primarily due to its caffeine content, 
                                but decaffeinated coffee is also commercially available. 
                                There are also various coffee substitutes.";
        private $comment = "Coffee is good.";

        public function getDescription() {
            return $this->description;
        }

        public function getComment() {
            return $this->comment;
        }
    }
?>