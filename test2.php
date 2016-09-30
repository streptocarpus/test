<?php

/**
 * Написать функцию которая из этого массива
 */
$data1 = [
    'parent.child.field' => 1,
    'parent.child.field2' => 2,
    'parent2.child.name' => 'test',
    'parent2.child2.name' => 'test',
    'parent2.child2.position' => 10,
    'parent3.child3.position' => 10,
];

//сделает такой и наоборот
$data = [
    'parent' => [
        'child' => [
            'field' => 1,
            'field2' => 2,
        ]
    ],
    'parent2' => [
        'child' => [
            'name' => 'test'
        ],
        'child2' => [
            'name' => 'test',
            'position' => 10
        ]
    ],
    'parent3' => [
        'child3' => [
            'position' => 10
        ]
    ],
];

$result = forward($data1);
print_r($result);
print_r(backward($result));

#############################################

/**
 * Обертка для обратной трансформации
 * @param array $source исходный массив
 * @return array
 */
function backward(array $source)
{
    $output = [];
    backward_proc($source,$output);
    return $output;
}

/**
 * Обратная трансофрмация
 * @param $source массив для трансформации
 * @param array $output сюда собираем результат
 * @param array $keys массив ключей
 * @return bool|float|int|string
 */
function backward_proc($source, array &$output, array $keys = [])
{
    if(is_scalar($source)){
        return $output[join('.',$keys)] = $source;
    }else{
        foreach($source as $k => $v){
            backward_proc($v,$output,array_merge($keys,[$k]));
        }
    }
}

/**
 * Прямая трансформация
 * @param array $source исходный массив
 * @return array
 */
function forward(array $source)
{
    $elem = $output = [];

    foreach($source as $k => $v){
        $elem = explode('.',$k); $elem[] = $v; // элемены из ключа + значение собираем в плоский массив
        proc_forward($elem,$output);
    }

    return $output;
}

/**
 * Обрабатывает одну пару ключ/значение для прямой трансформации
 * @param array $elem
 * @param $o
 */
function proc_forward(array $elem, &$o)
{
    if(sizeof($elem) <= 1) return;

    $key = array_shift($elem); // получаем ключ

    if(sizeof($elem) == 1){
        // когда в массиве остается последний элемент делаем его "листом" и завершаем рекурсию
        $o[$key] = $elem[0];
        return;
    }else{
        // обрабатываем урезанный массив элементов, создавая очередной ключ в результирующем массиве, если нужно
        proc_forward($elem,$o[$key]);
    }
}
