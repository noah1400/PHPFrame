<?php
use function Core\out;
use function Core\asset;
?>
<head>
    <?php
        asset('styles.css')
    ?>
</head>

<div>
    <p>
        <?php
            out($name);
        ?>
    </p>
</div>