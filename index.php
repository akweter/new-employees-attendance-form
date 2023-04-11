<?php
    session_start();
    // Fetch database connection in config file
    include_once("./Database/config.php");

    if (! isset($_SESSION['login'])){
        header('location: ./auth/login.php');
    }
    elseif (! isset($_SESSION['verify'])) {
        header('location: ./auth/verify.php');
    }
    ?>
    
    <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="Akweter James | Multipurpose website for students and IT people.">
        <meta name="description" content="Several freee and open source projects built with PHP, Javascript, Python, Java, Typescript, Ruby  and Rails. |Shop management system, Employee management system,  Converter, Online Note Maker.">
        <meta name="keywords" content="Akweter James, Portfolio, Projects, IT Projects, Web Development Projects, Student, IT workers, Ghana, Africa, America, PHP, HTML, CSS,  Javascript, Shop management system, Employee management system, Online Note Maker.">
        <meta name="robots" content="index, nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">
        <meta name="revisit-after" content="1 days">
        <meta name="author" content="James Akweter"><link rel="apple-touch-icon" sizes="180x180" href="/public/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon-16x16.png">
        <link rel="manifest" href="/public/site.webmanifest">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../node_modules/bootstrap.min.css">
        <title>Persol | Employees Dashboard</title>
        
        <style>
            .navbar{ color: white; }
            form{display:flex;flex-direction:row;}
            #ResetBtn{margin-left:1%}
            .searchInfo{padding: 0 1%;width:70%;}
        </style>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    </head>

        <header>
            <!-- Navigation -->
            <nav class="navbar navbar-expand-sm bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="./"><img src="/public/akweter.jpg" width="40" height="40" alt="Employee Management System"></a>
                    <div class="collapse row navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav">
                    <h1 class="justify-content-center">Admin Dashboard</h1>
                            <li class="col justify-content-end">
                                <li data-bs-toggle="modal" data-bs-target="#dashboardModal" class="my-2 list-unstyled btn btn-info">Account
                                </li>
                                <li style="margin-left:10px;" class="my-2 list-unstyled">
                                    <a href="./auth/logout.php" class="btn btn-danger">Sign Out</a>
                                </li>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

    <body>
        <main class="p-5">
                
                <form method="GET">
                    <a class="btn btn-info" href="./add.php"><i class="fa fa-plus fa-lg"></i></a>
                    <div class="searchInfo">
                        <input type="search" class="form-control" name="q"  placeholder=" <?php if(! isset($_GET['q'])){ echo("I am looking for..."); } else{ echo $_GET['q']; } ?> "/>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-search fa-lg"></i></button>
                    <a href='./' type="reset" class="btn btn-danger" name="ResetBtn" id="ResetBtn">Reset</a>                   
                </form>

                <table id="datatableId" class="table table-hover">
                    <thead>
                        <tr class='table-dark'>
                            <th scope="col">#</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">Department</th>
                            <th scope="col">Staff ID</th>
                            <th scope="col">View</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch all users from the database
                        $Data = mysqli_query($pdo, "SELECT * FROM `staffs_details` ORDER BY `id` ASC");
                        $count = 1;
                        while($persol_data = mysqli_fetch_array($Data)){
                            $_SESSION['firstname'] = $persol_data['firstName']; // Set session for firstname?>

                            <tr class='table-info'>
                                <td><?=$count++?></td>
                                <td><?=$persol_data['firstName']?></td>
                                <td><?=$persol_data['lastName']?></td>
                                <td><?=$persol_data['mobile']?></td>
                                <td><?=$persol_data['department']?></td>
                                <td><?=$persol_data['staffId']?></td>
                                <td><a href='./more.php?id=<?=$persol_data['id']?>'>More</td>
                                <td><a href='./edit.php?id=<?=$persol_data['id']?>'>Edit</a> | <a onclick="return confirm('Are you sure to delete this')" href='./erase.php?id=<?=$persol_data['id']?>'>Delete</a></td>
                            </tr>
                        <?php } ?>
                    </body>
                </table>
            <table class="table table-hover">
                <thead></thead>
                    <tbody>
                        <?php
                            require_once('./database/config.php');
                            if(isset($_GET['q'])){
                                $filter = $_GET['q'];
                                $scan = "SELECT * FROM `staffs_details` WHERE CONCAT(firstName,lastName,email,department) LIKE '%$filter%' ";
                                $list = 0;

                                $scan_run = mysqli_query($pdo, $scan);

                                if(mysqli_num_rows($scan_run) > 0){
                                    foreach($scan_run as $data){
                                        ?>
                                        <div class="row p-2">
                                            <div class="col list-group">
                                                <div>
                                                    <?=$list++?><a href="./more.php?id=<?=$data['id']?>" class="list-group-item-light"><?=$data['firstName']?> <?=$data['lastName']?><?=$data['department']?> Department</a>
                                                </div>
                                            </div>
                                        </div>
                                        <tbody>
                                    <?php }
                                }
                                else{ ?>
                                    <tr colspan="6">
                                        <td colspan="6">No records found</td>
                                    </tr>
                                <?php } } ?>       
                        </tbody>
                </table>
        </main>

        <!-- list-group-item list-group-item-action  -->
        <div class="modal fade" id="dashboardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="dashboardModal">User Information</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                                <strong>User Name</strong>
                                <input type="text" name="changeUser" class="form-control" value="username" ><br/>
                                <strong>Password</strong>
                                <input type="text" name="changePass" class="form-control" value="3u499" >
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Change" name="changeSubmit">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <footer style="background: #1A1110; color: white;" class="mt-5">
                <div class="row">
                    <div class="col col-md-2"></div>
                    <div style="display:flex; flex-direction:row;" class="col col-md-8">
                        <a href="https://github.com/john-BAPTIS?tab=repositories" target="_blank"><img style="border-radius: 50%; padding:50% 0" width="50px" height=}50ox" src="https://avatars.githubusercontent.com/u/71665600?v=4" alt="Logo"></a>
                        <p style=" padding:15px 0 15px 10px;">Copyright  © 2023 (Persol Development Team). <strong>Powered by: <a style="text-decoration:none" href="mailto:jamesakweter@gmail.com">Akweter</a></strong></p>
                    </div>
                    <div class="col col-md-2"></div>
                </div>
            </footer>
        </body>
    </html>
