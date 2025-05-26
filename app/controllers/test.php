<?php

namespace app\controllers;

use app\engine\Language;
use app\classes\{ Document, Param };

class test extends AbstractController
{

    public function index(): string
    {
        $price = 2500.1;
        $price_str = Language::num2str($price);
        $count = 4;
        $total_price = $price * $count;
        $total_pr_str = Language::num2str($total_price);

        $params = [
            new Param('${company}', 'Название компании', 0, 'Тестовая компания', true),
            new Param('${gendir}', 'ФИО директора', 0, 'Тестова Т. Т.', false),
            new Param('${date_start}', 'Дата начала ярмарки', 0, '1 марта', true),
            new Param('${date_end}', 'Дата окончания ярмарки', 0, '15 марта', true),
            new Param('${year}', 'Год', 0, '2025', true),
            new Param('${price}', 'Стоимость услуги', 1, $price, true),
            new Param('${price_str}', 'Стоимость услуги прописью', 0, $price_str, true),
            new Param('${count_people}', 'Количество участников', 1, $count, false),
            new Param('${total_price}', 'Итоговая цена', 1, $total_price, true),
            new Param('${total_pr_str}', 'Итоговая цена прописью', 0, $total_pr_str, true),
        ];
        $test = new Document('test2.docx', $params);
        $test->prepareDoc();

        return '';
    }

}

?>