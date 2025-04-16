<?php

@include_once(__DIR__ . '/template/head.inc.php');

?>
<body>

<div class="instellingen">
    <div class="kopjes">
        <a href="#">Mijn Account</a>
    </div>
    <div class="kopjes">
        <a href="#">Instellingen</a>
    </div>
    <div class="kopjes">
        <a href="#">Bestellingen</a>
    </div>
    <div class="kopjes">
        <a href="#">Wishlist</a>
    </div>
</div>
<style>
    .instellingen {
        display: flex;
        justify-content: center;
        margin: 30px 0;
        gap: 20px;
        flex-wrap: wrap;
        text-decoration: none;
    }

    .kopjes {
        background-color: #fff;
        padding: 10px 20px;
        border-radius: 25px;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: all 0.3s;

    }

    .kopjes a {
        text-decoration: none;
        color: #000000;
    }

    .kopjes:hover {
        background-color: #fefefe;
        color: rgb(255, 255, 255);
        border-color: #000000;


    }
</style>


</body>

<?php
@include_once(__DIR__ . '/template/foot.inc.php');