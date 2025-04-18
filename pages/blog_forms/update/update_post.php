<?php
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/constants.php";
    
    require $_SERVER["DOCUMENT_ROOT"]."/projects/blog-app/config/page_access.php";
    pageAccessControl(__FILE__);
?>

<!DOCTYPE html>
<html>
    <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'head.php' ?>

    <body>
    <!-- navigation menu -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'nav.php'; ?>

        <section class="form_section">
            <div class="form_container">
                <h2>Update Post</h2>
                <form class="form_inputs" action="">
                    <input type="text" placeholder="Title..."/>
                    <textarea rows=4 placeholder="Description..."></textarea>

                    <div class="post_category">
                        <p>Select Category: </p>
                        <select>
                            <option value="gaming">Gaming</option>
                            <option value="tech">Technology&nbsp;&nbsp;&nbsp;</option>
                            <option value="art">Art</option>
                            <option value="travel">Travel</option>
                        </select>
                    </div>

                    <div class="file_upload">
                        <label for="thumb">Update Thumbnail</label>
                        <input type="file" id="thumb" />
                    </div>

                    <div class="featured">
                        <div>
                            <input type="checkbox" id="featured_cbox" name="featured_cbox" checked/>
                        </div>
                        <label for="featured_cbox">Featured</label>
                    </div>

                    <div class="form_error_message">Error Here</div>
                    <button type="submit">Update Post</button>
                </form>
            </div>
        </section>

    <!-- Footer  -->
        <?php include ROOT_PATH.'pages'.$ds.'partials'.$ds.'footer.php'; ?>
    </body>
</html>