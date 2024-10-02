<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads</title>
    <link href="./access/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="nav text-bg-dark p-3 mb-5">
        <a class="nav-link text-reset" aria-current="page" href="./index.php">Home</a>
        <a class="nav-link text-reset active" href="./leads.php">Leads</a>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <form method="post" action="./getstatuses.php" id="getStatuses">
                    <div class="row">
                        <div class="col-4">
                            <label for="startDate">Start</label>
                            <input id="startDate" class="form-control" type="date" name="startDate" />
                        </div>
                        <div class="col-4">
                            <label for="endDate">End</label>
                            <input id="endDate" class="form-control" type="date" name="endDate" />
                        </div>
                        <div class="col-8 mt-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-8">
                <?php if (isset($_SESSION["leads"])) { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">FTD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION["leads"] as $lead) { ?>
                                <tr>
                                    <th scope="row"><?php echo $lead['id'] ?></th>
                                    <td><?php echo $lead['email'] ?></td>
                                    <td><?php echo $lead['status'] ?></td>
                                    <td><?php echo $lead['ftd'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } elseif (isset($_SESSION["leadsError"])) { ?>
                    <p class="text-danger">You have an issue: <?php echo $_SESSION["leadsError"]; ?></p>
                <?php } else { ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('getStatuses').submit();
                        });
                    </script>
                <?php }  ?>
            </div>
        </div>
    </div>
    <script src="./access/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php
unset($_SESSION['leads']);
unset($_SESSION['leadsError']);
?>