<div class="pagination">

    <div class="backward_buttons">
        <div class="backward_skip" onclick="moveToPage(<?php echo $current_page?>, <?php echo $page_count?>, 'backward_skip', '<?php echo DOMAIN_NAME?>')">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-skip-forward-fill" viewBox="0 0 16 16">
                <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.753l-6.267 3.636c-.54.313-1.233-.066-1.233-.697v-2.94l-6.267 3.636C.693 12.703 0 12.324 0 11.693V4.308c0-.63.693-1.01 1.233-.696L7.5 7.248v-2.94c0-.63.693-1.01 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5"/>
            </svg>
        </div>
        <div class="backward" onclick="moveToPage(<?php echo $current_page?>, <?php echo $page_count?>, 'backward', '<?php echo DOMAIN_NAME?>')">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fast-forward-fill" viewBox="0 0 16 16">
                <path d="M7.596 7.304a.802.802 0 0 1 0 1.392l-6.363 3.692C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696z"/>
                <path d="M15.596 7.304a.802.802 0 0 1 0 1.392l-6.363 3.692C8.713 12.69 8 12.345 8 11.692V4.308c0-.653.713-.998 1.233-.696z"/>
            </svg>
        </div>
    </div>

    <div class="page_number"><?php echo $current_page.' of '.$page_count?> pages</div>

    <div class="forward_buttons">
        <div class="forward" onclick="moveToPage(<?php echo $current_page?>, <?php echo $page_count?>, 'forward', '<?php echo DOMAIN_NAME?>')">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fast-forward-fill" viewBox="0 0 16 16">
                <path d="M7.596 7.304a.802.802 0 0 1 0 1.392l-6.363 3.692C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696z"/>
                <path d="M15.596 7.304a.802.802 0 0 1 0 1.392l-6.363 3.692C8.713 12.69 8 12.345 8 11.692V4.308c0-.653.713-.998 1.233-.696z"/>
            </svg>
        </div>
        <div class="forward_skip" onclick="moveToPage(<?php echo $current_page?>, <?php echo $page_count?>, 'forward_skip', '<?php echo DOMAIN_NAME?>')">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-skip-forward-fill" viewBox="0 0 16 16">
                <path d="M15.5 3.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V8.753l-6.267 3.636c-.54.313-1.233-.066-1.233-.697v-2.94l-6.267 3.636C.693 12.703 0 12.324 0 11.693V4.308c0-.63.693-1.01 1.233-.696L7.5 7.248v-2.94c0-.63.693-1.01 1.233-.696L15 7.248V4a.5.5 0 0 1 .5-.5"/>
            </svg>
        </div>
    </div>

</div>