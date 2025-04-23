<?php

    function get_longest_category_name(array &$categories) {
        if(count($categories) > 0) {
            /* 
                Check if the last element is null because fetch_assoc() always
                put null at the end of array.
            */
            $end = end($categories);
            if(!isset($end)) array_pop($categories);
    
            /* Find longest category name */
            $index = 0;
            # [0] = index, [1] = name-length
            # [2] = name
            $ln = [-1, 0, ''];
            foreach($categories as $key => $list) {
    
                $str_len = strlen($list['title']);
                if($ln[1] < $str_len) {
                    $ln[0] = $index;
                    $ln[1] = $str_len;
                    $ln[2] = $list['title'];
                }
                $index++;
            }
            //Add extra right space so that the red arrow in
            //select won't overlap the <select> content.
            $categories[$ln[0]]['title'] .= '&nbsp;&nbsp;&nbsp;&nbsp;';
            /* */
        }
    }
?>