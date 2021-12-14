<?php require_once "./header.php"; ?>

<div class="container">
    <h1 class='text-center m-2'>Users</h1>
    <div class="row">
        <div class="col-md-12">
            <a href="./addUser.php">New user</a>
            <table class="table">
            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            } ?>
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Image</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($users->getUsers() as $user) { ?>
                        <tr>
                            <td><?=$user['id']?></td>
                            <td><?=$user['name']?></td>
                            <td><?=$user['email']?></td>
                            <td><?=$user['password']?></td>
                            <td><?=$user['image']?></td>
                            <td>
                                <a href="./editUser.php?id=<?=$user['id']?>">Edit</a> |
                                <a href="./controller/UserController.php?id=<?=$user['id']?>&currentImage=<?=$user['image']?>&action=Delete">Delete</a>
                            </td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require_once "./footer.php"; ?>