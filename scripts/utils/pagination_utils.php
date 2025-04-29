<?php

    $item_per_page = 5;

    function resolve_page_count(&$page_count, $page_item_count) {

        global $item_per_page;

        // if $page_count is 0, total pages is less than $item_per_page.
        // Although, there may be still some items. Thus, set it to 1.
        if($page_count < 1) {
            $page_count = 1;
        }
        else {
            //excess page count that is not divisible by $item_per_page
            $excess_page = $page_item_count%$item_per_page;
            //Add another page if $excess_page has remainder
            if($excess_page > 0) $page_count += 1;
        }
    }

    function get_posts_count($connection, $id) {
        $get_posts_count = "SELECT COUNT(id) as posts_ln FROM posts";

        if(isset($id)) {
            $get_posts_count .= " WHERE id !=$id";
        }

        $result = $connection->query($get_posts_count);

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['posts_ln'];
        }
        return 0;
    }

?>