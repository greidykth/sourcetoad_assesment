<?php


function printOut($data, $key = null, $spaces = '')
{
    //1.Validate if data is an array
    if (!is_array($data)) {
        // 1.1 If it's not an array, print it
        $dataPrint = ($data || $data === 0 ) ? $data : "null";
        if (is_bool($data)) {
            $dataPrint = $data ? "true" : "false";
        }
        if ($key) {
            echo $spaces . $key . ' => ' . $dataPrint . "\n";
        } else {
            echo $spaces . $data . "\n";
        }
    } else {
        //1.2 Otherwise
        //1.2.1 Iterate through the array items
        $resultado = $spaces;
        if ($key && !is_int($key)) {
            $resultado .= $key;
        }
        echo $resultado . '[' . "\n";
        foreach ($data as $currentKey => $currentValue) {
            //1.2.1.1 Execute the printOut() function for $currentValue
            printOut( $currentValue, $currentKey, $spaces . "   ");
        }
        echo $spaces . ']' . "\n";
    }
}
