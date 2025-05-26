<?php

namespace app\controllers;

use app\classes\Param;
use ArrayIterator;

class ParamController extends AbstractController
{
    private static function load(): array
    {
        return json_decode(file_get_contents("params.json"));
    }

    private static function save($params): void
    {
        file_put_contents("params.json", json_encode($params));
    }

    public static function getParams(): array
    {
        $params = [
            new Param('${price}', 'Стоимость услуги', 1, ParamController::getPrice(), true),
            new Param('${count_people}', 'Количество участников', 1, 0, false, 0, 50),
        ]; // Здесь указаны обязательные параметры, которые всегда должны быть в шаблоне
        $params = array_merge($params, ParamController::load());
        return $params;
    }

    public function printParams(): string
    {
        return json_encode($this->getParams());
    }

    public function setPrice(int $price): string
    {
        if($price < 1) return '0';
        file_put_contents("other.json", json_encode(array("price" => $price)));
        return 'done';
    }

    public static function getPrice(): int
    {
        return json_decode(file_get_contents("other.json"))->price;
    }

    public function index(): string
    {
        
    }

    public function create(): string
    {
        $varInDoc = $this->request->varInDoc;
        $name = $this->request->name;
        $type = $this->request->type;
        $value = $this->request->value;
        $isStatic = $this->request->isStatic;
        $minValue = $this->request->minValue;
        $maxValue = $this->request->maxValue;
        if($varInDoc == null || $name == null) return 'fail';

        $params = ParamController::load();
        $type = intval($type);
        if($type == 1) $value = intval($value);
        array_push($params, new Param($varInDoc, $name, $type, $value, $isStatic, intval($minValue), intval($maxValue)));
        ParamController::save($params);
        return 'done';
    }

    public function delete(): string
    {
        $varInDoc = $_GET['varInDoc'];
        $params = ParamController::load();
        for( $i = 0; $i < count($params); $i++ ) {
            if($params[$i]->varInDoc == $varInDoc) {
                unset($params[$i]);
                break;
            }
        }
        ParamController::save($params);
        return 'done';
    }
}