<?php
    require_once("regex.php");
    header('Content-Type: application/javascript; charset=utf-8');
    ?>
    window.formPatterns = {
    name: <?php echo json_encode(NAME_REGEX) ?>,
    email: <?php echo json_encode(EMAIL_REGEX) ?>
};
