<?php
    require 'conn.php';
    $sqlshow = SELECT  FROM activities;
    $query = mysqli_query($conn, $sqlshow);
    $fetch = mysqli_fetch_all($query,MYSQLI_ASSOC);
    ?>