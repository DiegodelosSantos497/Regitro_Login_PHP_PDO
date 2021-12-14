<?php require_once "./header.php"; ?>

<div class="container">
    <h1 class='text-center m-2'>Users</h1>
    <div class="row">
        <div class="col-md-12">
            <a href="./allUsers.php">Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <form action="./controller/UserController.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="col">
                        <label for="password2">Confirm Password</label>
                        <input type="password" class="form-control" name="password2" id="password2">
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control p-1" name="image" id="image">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" name="action" value="Add">
                </div>
            </form>
            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            } ?>
        </div>
    </div>
</div>


<?php require_once "./footer.php"; ?>