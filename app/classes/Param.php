<?php

namespace app\classes;

class Param {
    public $varInDoc;
    public $name;
    public $type;
    public $maxValue;
    public $minValue;
    public $value;
    public $isStatic = false;

    public function __construct($varInDoc, $name, $type, $value, $isStatic, $minValue = 0, $maxValue = 0) {
        $this->varInDoc = $varInDoc;
        $this->name = $name;
        $this->type = $type;
        $this->isStatic = $isStatic;
        $this->value = $value;
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
    }

    public static function check($param): bool {
        if(is_string($param->value)) {
            return strlen($param->value) <= 255;
        }
        if(is_numeric($param->value)) {
            return $param->value >= $param->minValue && $param->value <= $param->maxValue;
        }

        return false;
    }
}

?>