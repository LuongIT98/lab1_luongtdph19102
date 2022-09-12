<?php
function query_all_category()
{
    $sql = "SELECT * FROM `category` WHERE 1";
    return pdo_query($sql);
}