<?php

namespace app\engine;

use PhpOffice\PhpWord\TemplateProcessor;

class Word
{

    public static function loadDocument($path): TemplateProcessor
    {
        $doc = new TemplateProcessor($path);
        return $doc;
    }

    public static function saveDocument($doc, $path)
    {
        $doc->saveAs($path);
    }

    public static function applyValues($doc, $params)
    {
        for ($i = 0; $i < count($params); $i++) {
            $doc->setValue($params[$i]->varInDoc, $params[$i]->value);
        }
    }

    public static function prepareDocument($path, $params): string
    {
        $doc = Word::loadDocument($path);
        Word::applyValues($doc, $params);
        do {
            $newPath = \app\engine\Config::$docsDir . rand() . '.docx';
        } while(file_exists($newPath));
        Word::saveDocument($doc, $newPath);
        return $newPath;
    }

}

?>