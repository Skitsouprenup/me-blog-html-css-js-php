<?php 
    $dashboard_link = DOMAIN_NAME.'pages/views/dashboard/manage_posts.php';
    $home_link = DOMAIN_NAME.'index.php';
    $login_page = DOMAIN_NAME.'pages/forms/signin.php';
?>

<nav class="nav">
    <div class="nav__container">
        <a href=<?php echo $home_link ?> class="nav__logo">Me Blog</a>
        <div class="nav__options">

            <a href="#">Blogposts</a>
            <a href="#">About</a>
            <a href="#">Contact</a>

            <div class="nav__options_credentials">

                <div class="nav__options_credentials_image">
                    <img src=<?php echo DOMAIN_NAME."images/avatar/52685143.jpg" ?> />

                    <div class="nav__options_credentials_options">

                        <ul class="nav__options_credentials_options_list">
                            <li><a href=<?php echo $dashboard_link ?>>Dashboard</a></li>
                            <li><a href=<?php echo $login_page ?>>Sign Out</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <div class="nav__options_mobile">

            <div class="choices">
                <div class="menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                    </svg>
                </div>
                <div class="close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </div>

                <div class="nav__options_credentials_options_mobile">

                    <ul class="nav__options_credentials_options_list">
                        <li><a href="#">Blogposts</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href=<?php echo $dashboard_link ?>>Dashboard</a></li>
                        <li><a href=<?php echo $login_page ?>>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</nav>