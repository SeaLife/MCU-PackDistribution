<html>
    <head>
        <link href="https://bootswatch.com/4/materia/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <title>ModPack Admin Interface</title>
    </head>

    <body>
        <div class="container-fluid">
            <br>
            <div class="card">
                <div class="card-header">
                    Admin Interface for ModPack <b><?php echo $_SESSION["APP_PACK"]; ?></b>
                </div>
            </div>
        </div>
        <br/>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <b>Actions</b>
                </div>
                <div class="card-body">
                    - &nbsp; <a href="/index.php/admin/choose-pack">Choose a Pack</a><br/>
                    - &nbsp; <a href="/index.php/admin/logout">Sign out</a>
                </div>
            </div>
        </div>
    </body>
</html>