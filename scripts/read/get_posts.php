<?php

    function get_posts($connection, $featured_post) {
        $posts = NULL;
        /*
            This is how inner join works. Inner join combines two table
            columns from two different tables and display those columns as
            a row if the condition after the 'ON' clause is true. Inner join
            scans two tables row-by-row. For example you have this table1 with 
            these columns: id,t2_id,firstname and lastname Next, you have 
            table2: id,title,content Next, this is the condition for 
            'ON': table2.id=table.t2_id Next, this is the whole query:
            SELECT table2_title,table1_firstname FROM table1 INNER JOIN table2
            ON table1.id=table2.t2_id

            First off, mysql takes the first row on the left table(table1) and then
            it will try to combine the row to the right row. If the condition after the 'ON'
            clause is true to that row, for example, if id on the left row is equal to
            t2_id on the right row, then the row from left and right table will be combined
            and include to the resultset. Otherwise, the whole row will be skipped and then
            the current row on the left will be combined to the second row on the right.
            If the condition is true, row #1 on the left will be combined to the row #2 on 
            the right. Continue this step until all rows on the left are exhausted.

            Note: This is just my assumption and it may only work on one-to-many
            relationship where one 'foreign constrained' column either on left or
            right table has unique constraint. One-to-one relationship where both 
            'foreign constrained' columns on both tables are unique, might have a different 
            process.

            Note: This is the process for INNER JOIN. Other joins like LEFT and RIGHT
            joins have different ways of filling up the resultset.
        */
        $get_posts = 
            "SELECT p.title as post_title,p.content,p.thumbnail,p.time_created,p.category_id,".
            "cat.title as cat_title,usr.firstname,usr.lastname,usr.avatar FROM posts as p ".
            "INNER JOIN categories as cat ON cat.id=p.category_id ".
            "INNER JOIN users as usr ON usr.id=p.author_id";

        //Exclude Featured post from list of posts.
        if(isset($featured_post['id'])) {
            $get_posts .= " WHERE p.id != {$featured_post['id']}";
        }

        $result = $connection->query($get_posts);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
                $posts[] = $row;
        }

        return $posts;
    }

    function get_featured_post($connection) {
        /* Get Featured Post */
        $get_featured_post = "SELECT post_id FROM featured_post WHERE id=1";
        $result = $connection->query($get_featured_post);
        $featured_post = [];

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if(isset($row['post_id'])) {

                $get_post = "SELECT id,title,content,thumbnail,time_created,category_id,author_id".
                " FROM posts WHERE id=".$row['post_id']." LIMIT 1";
                $fetched_post = $connection->query($get_post);

                if($fetched_post->num_rows > 0) {
                    $featured_post = $fetched_post->fetch_assoc();
                    
                    //Get category and user
                    $fetch_post_cat_user = 
                        "SELECT cat.title,usr.firstname,usr.lastname,usr.avatar ".
                        "FROM (SELECT title FROM categories WHERE id=".$featured_post['category_id'].") as cat,".
                        "(SELECT firstname,lastname,avatar FROM users WHERE id=".$featured_post['author_id'].") as usr";
                    $fetch_data = $connection->query($fetch_post_cat_user);

                    if($fetch_data->num_rows > 0) {
                        $cat_user = $fetch_data->fetch_assoc();

                        $featured_post['category'] = $cat_user['title'];
                        $featured_post['name'] = $cat_user['firstname'].' '.$cat_user['lastname'];
                        $featured_post['avatar'] = $cat_user['avatar'];
                    }
                }

                return $featured_post;
            } else return NULL;
        }
        /* ### */
    }
?>