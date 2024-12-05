<?php use PET\settings\styles;  ?>

<script src='js/session.js'></script>
<script src='js/base.js'></script>
<link rel="stylesheet" href="resources/css/index.css" type="text/css" />
<link rel="stylesheet" href="resources/css/custom.css" type="text/css" />
<style>
    :root{
        --paw-print-color: rgba(107, 142, 173, 0.1); /* Very light steel blue */
        <?php print(styles::getTheme($theme)) ?>
    }
</style>