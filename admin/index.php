<?php
include '../model/pdo.php';
include '../model/tour.php';
include '../model/category.php';

include 'header.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list_tour':
            $list_tour = query_all_tour();
            include 'tours/list.php';
            break;
        case 'delete_tour':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                delete_tour($id);
            }
            $list_tour = query_all_tour();
            include 'tours/list.php';
            break;
        case 'add_tour';
            if (isset($_POST['add_tour'])) {
                $error = [];
                $check = 0;
                $name = $_POST['name'];
                $intro = $_POST['intro'];
                $description = $_POST['description'];
                $number_date = $_POST['number_date'];
                if (empty($number_date) || $number_date <= 0) {
                    $error['number_date'] = "Không được bỏ trống và phải là số dương";
                    $check++;
                }
                $price = $_POST['price'];
                if (empty($price) || $price <= 0) {
                    $error['price'] = "Không được bỏ trống và phải là số dương";
                    $check++;
                }
                $category_id = $_POST['category'];

                $target_dir = "../upload/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                if ($_FILES["image"]['size'] <= 0) {
                    $error['file_size'] = "Chưa có file";
                    $check++;
                } else {
                    if ($_FILES["image"]['size'] > 2036000) {
                        $error['file_size'] = "File lớn hơn cho phép";
                        $check++;
                    }
                    $cut_duoi_img = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $imageFileType = strtolower($cut_duoi_img);
                    $duoianh = ["jpg", "png"];
                    if (!in_array($imageFileType, $duoianh)) {
                        $error['file_type'] = "File không đúng định dạng";
                        $check++;
                    }
                }

                if ($check == 0) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $image = $target_file;
                        add_tour($name, $image, $intro, $description, $number_date, $price, $category_id);
                        echo "Thêm thành công";
                    } else {
                        echo "Thêm không thành công";
                    }
                }
            }
            $list_category = query_all_category();
            include 'tours/add.php';
            break;
        case 'update_tour':
            if (isset($_GET['id'])) {
                $id_tour = $_GET['id'];
                $infor_tour = query_one_tour($id_tour);
            }

            if (isset($_POST['update_tour'])) {
                $error = [];
                $check = 0;
                $chec_img = 0;
                $name = $_POST['name'];
                $intro = $_POST['intro'];
                $description = $_POST['description'];
                $number_date = $_POST['number_date'];
                if (empty($number_date) || $number_date <= 0) {
                    $error['number_date'] = "Không được bỏ trống và phải là số dương";
                    $check++;
                }
                $price = $_POST['price'];
                if (empty($price) || $price <= 0) {
                    $error['price'] = "Không được bỏ trống và phải là số dương";
                    $check++;
                }
                $category_id = $_POST['category'];

                $target_dir = "../upload/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                if ($_FILES["image"]['size'] <= 0) {
                    $chec_img++;
                } else {
                    if ($_FILES["image"]['size'] > 2036000) {
                        $error['file_size'] = "File lớn hơn cho phép";
                        $check++;
                    }
                    $cut_duoi_img = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $imageFileType = strtolower($cut_duoi_img);
                    $duoianh = ["jpg", "png"];
                    if (!in_array($imageFileType, $duoianh)) {
                        $error['file_type'] = "File không đúng định dạng";
                        $check++;
                    }
                }

                if ($check == 0) {
                    if ($chec_img != 0) {
                        $image = "";
                        update_tour($name, $image, $intro, $description, $number_date, $price, $category_id, $id_tour);
                        echo "Update thành công";
                        $infor_tour = query_one_tour($id_tour);
                    } else {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            $image = $target_file;
                            update_tour($name, $image, $intro, $description, $number_date, $price, $category_id, $id_tour);
                            echo "Update thành công";
                            $infor_tour = query_one_tour($id_tour);
                        } else {
                            echo "Update không thành công";
                        }
                    }
                }
            }
            $list_category = query_all_category();
            include 'tours/update.php';
            break;
    }
} else {
    include 'home.php';
}
include 'foodter.php';
