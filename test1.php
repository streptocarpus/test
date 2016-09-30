<?php
/**
 * Нужно написать код, который из массива выведет то что приведено ниже в комментарии.
 */
$x = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

/*
print_r($x) - должен выводить это:
Array
(
    [h] => Array
        (
            [g] => Array
                (
                    [f] => Array
                        (
                            [e] => Array
                                (
                                    [d] => Array
                                        (
                                            [c] => Array
                                                (
                                                    [b] => Array
                                                        (
                                                            [a] =>
                                                        )

                                                )

                                        )

                                )

                        )

                )

        )

);*/

$output = [];
proc($x,$output);
print_r($output);

/**
 * Трансформация массива
 * @param $output
 * @param array $x
 */
function proc(array $x,&$output)
{
    $key = array_pop($x); // забираем очередной ключ с конца
    if(sizeof($x) == 0){ // завершаем рекурсию когда забрали последний ключ
        return $output[$key] = '';
    }else{
        // создаем промежуточный ключ
        proc($x,$output[$key]);
    }
}
