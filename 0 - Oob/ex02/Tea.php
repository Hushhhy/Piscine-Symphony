<?php
    class Tea extends HotBeverage {
        const nom = "Tea";
        const price = 3.50;
        const resistance = 2;
        private $description = "Tea is an aromatic beverage prepared by pouring hot or boiling water over cured or fresh leaves of Camellia sinensis, 
                                an evergreen shrub native to East Asia which originated in the borderlands of south-western China, 
                                north-east India and northern Myanmar. Tea is also made, but rarely, from the leaves of Camellia taliensis. 
                                After plain water, tea is the most widely consumed drink in the world. There are many types of tea.";
        private $comment = "Thea is perfect.";

        public function getDescription() {
            return $this->description;
        }

        public function getComment() {
            return $this->comment;
        }
    }
?>