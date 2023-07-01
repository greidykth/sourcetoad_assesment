<?php

function sortData(&$arr, $criteria, $n)
{
    // Base case
   if ($n == 1)
        return;

    $count = 0;
    // One pass of bubble sort. After
    // this pass, the largest element
    // is moved (or bubbled) to end.
    for ($i=0; $i<$n-1; $i++)
        if (compare($arr[$i], $arr[$i+1], $criteria)){
            $aux = $arr[$i];
            $arr[$i] = $arr[$i+1];
            $arr[$i+1] = $aux;
            $count++;
        }
  
      // Check if any recursion happens or not
      // If any recursion is not happen then return
      if ($count==0) return;
  
    // Largest element is fixed,
    // recur for remaining array
    sortData($arr, $criteria, $n-1);
}

function compare($arg1, $arg2, $criteria)
{
    $value1 = getValue($arg1, $criteria[0]);
    $value2 = getValue($arg2, $criteria[0]);
    // 1 If value 1 is greater than value 2 return true
    if($value1 > $value2){
        return true;
    // 2 Otherwise
    } else {
        // 2.1 if value 1 is equal to value 2
        if ($value1 == $value2){
            // 2.1.1 Shifts the first value of the array criteria off
            array_shift($criteria);
            // 2.1.2 If there are more criteria
            if(!empty($criteria)){
                // 2.1.1.1 return the value of recursively calling compare function
                return compare($arg1, $arg2, $criteria);
            }
        }
    }
    // 2.2.1 return false
    return false;
}

function getValue($arg, $key) {
  //1.Validate if arg is an array
    if (is_array($arg) ) {
        //1.1 Validate if $key exists
        if (array_key_exists($key, $arg)) {
            //1.1.1 Return $arg($key)
            return $arg[$key];
            //1.2 Otherwise
        } else {
            //1.2.1 Traverse the array
            foreach ($arg as $value) {
                //1.2.1.1 Get the value with getValue($value, $key)
                $resultado = getValue($value, $key);
                //1.2.1.2 If result got something
                if ($resultado) {
                    //1.2.1.2.1 return the value of result
                    return $resultado;
                }
            }
        }
    }
    //2 return false;
    return false;
}


