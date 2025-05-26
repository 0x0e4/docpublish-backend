<?php

namespace app\classes;

use app\engine\Word;

class Document {
    public $nameDoc;
    public $params = array();

    public function __construct($nameDoc, $params) {
        $this->nameDoc = $nameDoc;
        $this->params = $params;
    }

    public function loadParams($params) {
        $this->params = $params;
    }

    public function prepareDoc() {
        return Word::prepareDocument($this->nameDoc, $this->params);
    }
}

?>