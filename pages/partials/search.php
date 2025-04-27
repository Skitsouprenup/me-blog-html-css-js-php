<div class="search_bar__container">
    <form class="search_bar__form" action=<?php echo DOMAIN_NAME.'pages/views/search.php'?> method="get">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="black" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
            <input type="search" name="search" placeholder="Search..."/>
            <button type="submit">Search</button>
        </div>
    </form>
</div>