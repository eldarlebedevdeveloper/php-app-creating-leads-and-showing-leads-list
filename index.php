<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Api Integration</title>
    <link href="./access/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="nav text-bg-dark p-3 mb-5">
        <a class="nav-link text-reset active" aria-current="page" href="./index.php">Home</a>
        <a class="nav-link text-reset" href="./leads.php">Leads</a>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <form method="POST" action="./addlead.php">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php if (isset($_SESSION['formData']['firstName'])) {
                                                                                                            echo $_SESSION['formData']['firstName'];
                                                                                                        } ?>">
                        <?php if (isset($_SESSION['errors']['firstName'])) { ?>
                            <div class="form-text"><?php echo $_SESSION['errors']['firstName']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php if (isset($_SESSION['formData']['lastName'])) {
                                                                                                            echo $_SESSION['formData']['lastName'];
                                                                                                        } ?>">
                        <?php if (isset($_SESSION['errors']['lastName'])) { ?>
                            <div class="form-text"><?php echo $_SESSION['errors']['lastName']; ?></div>
                        <?php } ?>

                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php if (isset($_SESSION['formData']['phone'])) {
                                                                                                    echo $_SESSION['formData']['phone'];
                                                                                                } ?>">
                        <?php if (isset($_SESSION['errors']['phone'])) { ?>
                            <div class="form-text"><?php echo $_SESSION['errors']['phone']; ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php if (isset($_SESSION['formData']['email'])) {
                                                                                                    echo $_SESSION['formData']['email'];
                                                                                                } ?>">
                        <?php if (isset($_SESSION['errors']['email'])) { ?>
                            <div class="form-text"><?php echo $_SESSION['errors']['email']; ?></div>
                        <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
            <div class="col-8 mt-3">
                <?php if (isset($_SESSION["status"]) and $_SESSION["status"] === true) { ?>
                    <p class="text-success">Lead created: <?php echo $_SESSION["responseData"]["email"]; ?> </p>
                <?php } elseif (isset($_SESSION["status"]) and $_SESSION["status"] === false) { ?>
                    <p class="text-danger">Lead didn't create: <?php echo $_SESSION["responseData"]["error"]; ?> </p>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="./access/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
unset($_SESSION['status']);
unset($_SESSION['errors']);
unset($_SESSION['responseData']);
unset($_SESSION['formData']);
?>