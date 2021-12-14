<?php
if (isset($_REQUEST['action'])) {
    session_start();
    require_once("../config/Config.php");
    require_once("../models/UserModel.php");
    $obj = new UserModel();
    $allowedExtensions = array("jpg", "jpeg", "png");
    $path = "../images/user/";

    /* Fields */
    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : "";
    $image = isset($_FILES['image']) ? $_FILES['image'] : "";
    $currentImage = isset($_POST['currentImage']) ? $_POST['currentImage'] : "";
    $id = isset($_POST['id']) ? $_POST['id'] : "";

    switch ($_REQUEST['action']) {
        case 'Add':

            if (empty($name) || empty($email) || empty($password) || empty($password2) || empty($image['name'])) {
                $_SESSION['message'] = alert("danger", "Empty fields");
                header("location:../addUser.php");
            } else {
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                if ($password != $password2) {
                    $_SESSION['message'] = alert("danger", "Passwords must be the same");
                    header("location:../addUser.php");
                } elseif (!in_array($extension, $allowedExtensions)) {
                    $_SESSION['message'] = alert("danger", "Invalid file format");
                    header("location:../addUser.php");
                } else {
                    if (
                        move_uploaded_file($image['tmp_name'], $path . $image['name'])
                        && $obj->add($name, $email, sha1($password), $image['name'])
                    ) {
                        $_SESSION['message'] = alert("success", "User added successfully");
                        header("location:../addUser.php");
                    } else {
                        $_SESSION['message'] = alert("danger", "Error adding user");
                        header("location:../addUser.php");
                    }
                }
            }
            break;

        case 'Delete':
            if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $_GET['id']) {
                $_SESSION['message'] = alert("danger", "You cannot delete your own account");
                header("location:../allUsers.php");
            } elseif (empty($_GET['id']) || empty($_GET['currentImage'])) {
                $_SESSION['message'] = alert("danger", "Error: contact the programmer");
                header("location:../allUsers.php");
            } else {
                if (unlink($path . $_GET['currentImage']) && $obj->delete($_GET['id'])) {
                    $_SESSION['message'] = alert("success", "User deleted successfully");
                    header("location:../allUsers.php");
                } else {
                    $_SESSION['message'] = alert("danger", "Error deleting user");
                    header("location:../allUsers.php");
                }
            }
            break;

        case 'Update':
            if (empty($name) || empty($email) || empty($password) || empty($password2)) {
                $_SESSION['message'] = alert("danger", "Empty fields");
                header("location:../addUser.php");
            } else {
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                if ($password != $password2) {
                    $_SESSION['message'] = alert("danger", "Passwords must be the same");
                    header("location:../addUser.php");
                } else {
                    if (empty($image['name'])) {
                        if (
                            $obj->update($name, $email, sha1($password), $currentImage, $id)
                        ) {
                            if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $id) {
                                $_SESSION['user'] = [
                                    'id' => $id, 'name' => $name, 'email' => $email, 'password' => $password, 'image' => $currentImage
                                ];
                                $_SESSION['message'] = alert("success", "User edited successfully. Please log in again to save your changes");
                                header("location:../allUsers.php");
                            }else{
                                $_SESSION['message'] = alert("success", "User edited successfully");
                                header("location:../allUsers.php");
                            }
                        } else {
                            $_SESSION['message'] = alert("danger", "Error editing user");
                            header("location:../allUsers.php");
                        }
                    } else {
                        if (
                            unlink($path . $currentImage)
                            && move_uploaded_file($image['tmp_name'], $path . $image['name'])
                            && $obj->update($name, $email, sha1($password), $image['name'], $id)
                        ) {
                            if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $id) {
                                $_SESSION['user'] = [
                                    'id' => $id, 'name' => $name, 'email' => $email, 'password' => $password, 'image' => $image['name']
                                ];
                                $_SESSION['message'] = alert("success", "User edited successfully. Please log in again to save your changes");
                                header("location:../allUsers.php");
                            }else{
                                $_SESSION['message'] = alert("success", "User edited successfully. ");
                                header("location:../allUsers.php");
                            }
                        } else {
                            $_SESSION['message'] = alert("danger", "Error editing user");
                            header("location:../allUsers.php");
                        }
                    }
                }
            }
            break;
        case 'Login':
            if ($obj->login($email, $password)) {
                $_SESSION['user'] = $obj->login($email, $password);
                header("location:../allUsers.php");
            } else {
                $_SESSION['message'] = alert("danger", "Verify that the email and password are correct");
                header("location:../index.php");
            }
            break;

        default:
            # code...
            break;
    }
}
