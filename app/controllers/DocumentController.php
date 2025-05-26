<?php

namespace app\controllers;

use app\classes\{Param, Document};
use app\engine\Language;

class FindParamResult
{
    public $found = false;
    public $value = '';
}

class DocumentController extends AbstractController
{

    public function index(): string
    {

    }

    public function default(): string
    {
        return '';
    }

    public function findParamVar($param, $array): FindParamResult
    {
        $result = new FindParamResult();
        foreach ($array as $k => $v) {
            if ($param->varInDoc == $k) {
                if ($param->type == 1 && $param->minValue != 0 && $param->maxValue != 0 && ($param->value < $param->minValue || $param->value > $param->maxValue))
                    return $result;
                $result->found = true;
                $result->value = $param->type == 1 ? intval($v) : $v;
                break;
            }
        }

        return $result;
    }

    public function create(): string
    {
        $data = json_decode(file_get_contents('php://input'), false);
        $params = ParamController::getParams();
        $count_people = 0;
        foreach ($params as $key => $value) {
            if ($value->isStatic)
                continue;
            $result = $this->findParamVar($value, $data);
            if ($result->found == false)
                return '0';
            if ($k == '${count_people}')
                $count_people = intval($result->value);
            $value->value = $result->value;
            if(!Param::check($value))
                return '0';
        }

        $price = ParamController::getPrice();

        $params = array_merge($params, array(
            new Param('${price_str}', 'Стоимость услуги прописью', 0, Language::num2str($price), true),
            new Param('${total_price}', 'Итоговая цена', 1, $price * $count_people, true),
            new Param('${total_pr_str}', 'Итоговая цена прописью', 0, Language::num2str($price * $count_people), true)
        ) /* Параметры, добавляемые в документ автоматически. Они также обязательно должны быть в шаблоне */);

        $doc = new Document(\app\engine\Config::$pathTemplate, $params);
        $nameDoc = $doc->prepareDoc();
        return file_get_contents($nameDoc);
    }
}