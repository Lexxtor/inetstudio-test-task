<?php

// Задан многомерный массив, элементы которого могут содержать одинаковые id:
$array = [
    ['id' => 1, 'date' => '12.01.2020', 'name' => 'test1'],
    ['id' => 2, 'date' => '02.05.2020', 'name' => 'test2'],
    ['id' => 4, 'date' => '08.03.2020', 'name' => 'test4'],
    ['id' => 1, 'date' => '22.01.2020', 'name' => 'test1'],
    ['id' => 2, 'date' => '11.11.2020', 'name' => 'test4'],
    ['id' => 3, 'date' => '06.06.2020', 'name' => 'test3'],
];

// 1. Выделить уникальные записи (убрать дубли) в отдельный массив. В конечном массиве не должно быть элементов с одинаковым id
function arrayUniqueById($array) {
    $uniqueIds = [];
    return array_filter($array, function($v) use (&$uniqueIds) {
        if (in_array($v['id'], $uniqueIds)) {
            return false;
        }
        $uniqueIds[] = $v['id'];
        return true;
    });
}

$arrayUnique = arrayUniqueById($array);

// 2. Отсортировать многомерный массив по ключу (любому)
function arraySortBy($array, $key = 'id') {
    usort($array, function($a, $b) use ($key) {
        return $a[$key] <=> $b[$key];
    });
    return $array;
}

$arraySorted = arraySortBy($array);

// 3. Вернуть из массива только элементы, удовлетворяющие внешним условиям (например элементы с определенным id)
$arrayFiltered = array_filter($array, function($v) {
    if ($v['id'] == 2) {
        return true;
    }
    return false;
});

// 4. Изменить в массиве значения и ключи (использовать name => id в качестве пары ключ => значение)
$arrayCombined = array_column($array, 'id', 'name');

// 5. В базе данных имеется таблица с товарами goods (id INTEGER, name TEXT), таблица с тегами tags (id INTEGER, name TEXT) и таблица связи товаров и тегов goods_tags (tag_id INTEGER, goods_id INTEGER, UNIQUE(tag_id, goods_id)). Выведите id и названия всех товаров, которые имеют все возможные теги в этой базе.
// На выходе: SQL-запрос.

$sql = 'SELECT id, name FROM goods LEFT JOIN goods_tags ON (id = goods_id) GROUP BY id HAVING count(goods_id) = (select count(*) from tags);';

// 6. Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины, и все они (каждый) поставили высокую оценку (строго выше 5).
// create table evaluations
// (
//     respondent_id uuid primary key, -- ID респондента
//     department_id uuid,             -- ID департамента
//     gender        boolean,          -- true — мужчина, false — женщина 
//     value         integer       -- Оценка
// );
// На выходе: SQL-запрос.

$sql = 'SELECT DISTINCT department_id FROM evaluations WHERE gender = true AND value > 5';
