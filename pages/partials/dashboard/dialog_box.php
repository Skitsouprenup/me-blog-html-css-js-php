<div class="dashboard_dialog_box_wrapper">
    <div class="dashboard_dialog_box">
        <button type="button" onclick="hideDialogBox()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708"/>
            </svg>
        </button>

        <div class="info">
            <h2 class="title"><?php echo $dialog_box_title?></h2>
            <p class="description">Are you sure about this?</p>
        </div>
        
        <div class="interface">
            <?php if($operation === 'user'):?>
                <a href="#" class="delete_user"><div>Delete</div></a>
            <?php endif?>
            <?php if($operation === 'post'):?>
                <a href="#" class="delete_post"><div>Delete</div></a>
            <?php endif?>
            <?php if($operation === 'category'):?>
                <a href="#" class="delete_category"><div>Delete</div></a>
            <?php endif?>
        </div>
    </div>
</div>