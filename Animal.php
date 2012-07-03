<?php

class Animal {

    private $av;
    private $bav;

    public function getResult($a, $b) {
        $this->a = $a;
        $this->b = $b;
        echo $this->a + $this->b;
        return 1;
    }

}
