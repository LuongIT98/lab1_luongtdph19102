<?php
function query_all_tour()
{
    $sql = "SELECT ts.id, ts.name, ts.image, ts.intro, ts.description, ts.number_date, ts.price, ct.id AS 'id_cate', ct.name AS 'name_cate' FROM `tours` ts
    JOIN category ct on ts.category_id = ct.id
    ORDER by ts.id DESC";
    return pdo_query($sql);
}

function add_tour($name, $image, $intro, $description, $number_date, $price, $category_id)
{
    $sql = "INSERT INTO `tours`(`name`, `image`, `intro`, `description`, `number_date`, `price`, `category_id`) 
    VALUES ('" . $name . "','" . $image . "','" . $intro . "','" . $description . "'," . $number_date . "," . $price . "," . $category_id . ")";
    pdo_execute($sql);
}

function query_one_tour($id)
{
    $sql = "SELECT ts.id, ts.name, ts.image, ts.intro, ts.description, ts.number_date, ts.price, ct.id AS 'id_cate', ct.name AS 'name_cate' FROM `tours` ts
    JOIN category ct on ts.category_id = ct.id 
    WHERE ts.id = " . $id;
    return pdo_query_one($sql);
}

function update_tour($name, $image, $intro, $description, $number_date, $price, $category_id, $id_tour)
{
    if($image == ""){
        $sql = "UPDATE `tours` SET `name`='" . $name . "',`intro`='" . $intro . "',`description`='" .
        $description . "',`number_date`=" . $number_date . ",`price`=" . $price . ",`category_id`=" . $category_id . " WHERE id = " . $id_tour;
    }else{
        $sql = "UPDATE `tours` SET `name`='" . $name . "',`image`='" . $image . "',`intro`='" . $intro . "',`description`='" .
        $description . "',`number_date`=" . $number_date . ",`price`=" . $price . ",`category_id`=" . $category_id . " WHERE id = " . $id_tour;
    }
    pdo_execute($sql);
}

function delete_tour($id)
{
    $sql = "DELETE FROM `tours` WHERE id = " . $id;
    pdo_execute($sql);
}
