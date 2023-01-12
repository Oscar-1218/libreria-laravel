<?php
session_start();

if($_POST){
    if($_POST['user'] == 'admin' && $_POST['password'] == '1234') {
        $_SESSION['user']='ok';       
        $_SESSION['nombreUsuario']='a';       
        header('Location:/crud_libreria_mysql/admin/principal/inicio.php');
    }else{
        $alerta = true;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrador</title>
    <!-- CSS only -->    
    <link rel="stylesheet" href="../../css/bootstrapAdmin.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
 </head>
<body>

    <h2>Modo administrador</h2>
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if(isset($alerta)){?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error: usuario o contraseña incorrectas',
        })</script>
    <?php }?>

    
    
    
    <div class="container">
    <form class="card" method="post" style="max-width: 38rem;">
            <div class="mb-3 card-body">
                <label for="exampleDropdownFormEmail2" class="form-label">User</label>
                <input type="text" name="user" required class="form-control" id="exampleDropdownFormEmail2" placeholder="user">
            </div>
            <div class="mb-3 card-body">
                <label for="exampleDropdownFormPassword2" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required id="exampleDropdownFormPassword2" placeholder="Password">
            </div>
            <div class="mb-3">
                <div class="form-check">
                <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                <label class="form-check-label" for="dropdownCheck2">
                    Remember me
                </label>
                </div>
            </div>
            <div class="card-body">
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
        </form>
    </div>
<!-- JavaScript Bundle with Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->

</body>
</html>