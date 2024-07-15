<?php
include_once "../class/connection.php";
$con = new connection;
$conn = $con->conectar();
$prod = mysqli_real_escape_string($conn, $_GET['id']);
session_start();

$sqlReceta = "SELECT DISTINCT TipoReceta FROM receta";
$resultReceta = mysqli_query($conn, $sqlReceta);
$TipoReceta = [];
while ($row = mysqli_fetch_assoc($resultReceta)) {
    $TipoReceta[] = $row['TipoReceta'];
}

$sqlCategorias = "SELECT DISTINCT producto_categoria FROM producto";
$resultCategorias = mysqli_query($conn, $sqlCategorias);
$categorias = [];
while ($row = mysqli_fetch_assoc($resultCategorias)) {
    $categorias[] = $row['producto_categoria'];
}


?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+ES+Deco:wght@100..400&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahorrando</title>
</head>

<body style="background-color: rgb(255, 255, 255);">
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="../views/index.php">
        Ahorrando®
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Categorías
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php foreach ($categorias as $categoria) { ?>
                <li><a class="dropdown-item"
                    href="../views/view-categorias.php?producto_categoria=<?php echo $categoria; ?>"><?php echo $categoria; ?></a>
                </li>
              <?php } ?>

            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Recetas
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
              <?php foreach ($TipoReceta as $TipoRecetas) { ?>
                <li><a class="dropdown-item"
                    href="../views/view-cat-receta.php?TipoReceta=<?php echo $TipoRecetas; ?>"><?php echo $TipoRecetas; ?></a>
                </li>
              <?php } ?>
              <li><a class="dropdown-item" href="../views/view-cat-receta.php?"> Todas </a></li>
            </ul>
          </li>
        </ul>
        <form class="d-flex me-auto w-50" role="search" action="../class/search.php" method="GET">
          <input class="form-control me-1 w-50" id="searchInput" type="search" name="buscar" placeholder="Buscar"
            aria-label="Search">
          <button class="btn btn-outline-success" type="submit">🔎</button>
        </form>
        <ul class="navbar-nav">
          <?php if (isset($_SESSION['username'])) { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Bienvenido, <?php echo $_SESSION['username']; ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                <li><a class="dropdown-item" href="../views/view-listacompra.php">Lista de compras</a></li>
                <li><a class="dropdown-item" href="../class/Cerrarsesion.php">Cerrar sesión</a></li>
              </ul>
            </li>
          <?php } else { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarLoginDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Iniciar sesión
              </a>
              <div class="dropdown-menu dropdown-menu-end p-4" aria-labelledby="navbarLoginDropdown">
                <form action="../class/pass.php" name="f1" onsubmit="return validation()" method="POST">
                  <div class="mb-3">
                    <label for="exampleDropdownFormEmail2" class="form-label">👨🏽‍💼</label>
                    <input type="text" id="user" class=" fadeIn second" name="user" placeholder="Usuario" required>
                  </div>
                  <div class="mb-3">
                    <label for="exampleDropdownFormPassword2" class="form-label">🔏</label>
                    <input type="password" name="pass" class=" fadeIn third" id="pass"
                      placeholder="Contraseña" required onkeyup="maskPassword(this)">
                  </div>
                  <?php
                  $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
                  unset($_SESSION['error_message']);
                  if (!empty($errorMessage)) {
                    echo '<p style="color: red;">' . $errorMessage . '</p>';
                  }
                  ?>
                  <button type="submit" class="btn btn-primary" style="margin-left: 35px;">Iniciar sesión</button>
                  <p style="display: flex; justify-content: center;">¿Aun no tienes cuenta?</p><a href="../views/view-register.php"
                    style="display: flex; justify-content: center;">Regístrate</a>
                </form>
              </div>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <br>
  <a href="javascript:history.back()" class="btn btn-link text-decoration-none" style="margin-left:30%; color: black">⬅️ Volver</a>
  <div class="container" style="background-color:rgb(255,255,255); margin-top: 25px;">
  <div class="container" style="background-color:white; margin-top: 25px;">
    <div class="row justify-content-center">
      <?php
      if ($conn != true) {
        die("Error de conexión " . mysqli_connect_error());
      }
      $sql = "SELECT `id`, `Name`, `Desc`, `TipoReceta`, `Image` FROM `receta` WHERE id LIKE '$prod'";
      $resultSet = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($resultSet)) {
        $id = $row['id'];
        $name = $row['Name'];
        $urlImagen = $row['Image'];
        $Desc = $row['Desc'];
       
      ?>
        <?php $descripcion ?>
        <div class="col-md-5 col-lg-8">
          <div class="card" style="background-color: white; border-radius: 40px; box-shadow: 15px 15px 15px;">
            <div class="row g-4">
              <div class="col-md-6">
                <img src="<?php echo $urlImagen; ?>" class="card-img-top" alt="Imagen" style="border-radius: 30px; max-width: 85%; margin-left: 5%;">
              </div>
              <div class="col-md-6">
                <div class="card-body">
                  <h5 class="card-title" style="color: Black;"><?php echo $name; ?></h5>
                 
                  <p class="card-text" style="color: Black;"><?php echo $Desc; ?></p>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</div>
  
</body>
      <br>
      <!-- paginacion -->
     

    </div>

    <script>
      function toggleForm() {
        var form = document.getElementById("filter-form");

        // Verificar si el formulario está oculto
        if (form.style.display === "none") {
          // Mostrar el formulario con animación
          form.style.opacity = 0;
          form.style.display = "block";
          // Aplicar la animación de fundido
          fadeIn(form);
        } else {
          // Ocultar el formulario con animación
          fadeOut(form, function() {
            form.style.display = "none";
          });
        }
      }

      // Función para animar la aparición gradual del elemento
      function fadeIn(element) {
        var opacity = 0;
        var timer = setInterval(function() {
          if (opacity >= 1) {
            clearInterval(timer);
          }
          element.style.opacity = opacity;
          opacity += 0.1;
        }, 50);
      }

      // Función para animar la desaparición gradual del elemento
      function fadeOut(element, callback) {
        var opacity = 1;
        var timer = setInterval(function() {
          if (opacity <= 0) {
            clearInterval(timer);
            callback();
          }
          element.style.opacity = opacity;
          opacity -= 0.1;
        }, 50);
      }
    </script>

</body>

<footer class="" style="margin-left:0px; color:black;">
  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    <div class="me-5 d-none d-lg-block">
      <span>Conéctate con nosotros en las redes sociales:</span>
    </div>
    <div>
      <a href="https://www.facebook.com/" target="_blank" class="me-4 text-reset">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="https://twitter.com/home" target="_blank" class="me-4 text-reset">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="https://www.google.cl/?gws_rd=ssl" target="_blank" class="me-4 text-reset">
        <i class="fab fa-google"></i>
      </a>
      <a href="https://www.instagram.com/" target="_blank" class="me-4 text-reset">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="https://www.linkedin.com/feed/" target="_blank" class="me-4 text-reset">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="https://github.com/" target="_blank" class="me-4 text-reset">
        <i class="fab fa-github"></i>
      </a>
    </div>
  </section>
  <section class="" style="background-color: rgba(255, 255, 255)">
    <div class="container text-center text-md-start mt-5">
      <div class="row mt-3">
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>Ahorrando
          </h6>
          <p>
            Los mejores precio en Ahorrando para los consumidores
          </p>
        </div>
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4" style="background-color: rgba(255, 255, 255)">
          <h6 class="text-uppercase fw-bold mb-4">
            Categorias
          </h6>
          <p>
            <a href="../views/view-categorias.php?producto_categoria=Lácteos" class="text-reset">Lácteos</a>
          </p>
          <p>
            <a href="../views/view-categorias.php?producto_categoria=Frutas%20y%20verduras" class="text-reset">Frutas Y Verduras</a>
          </p>
          <p>
            <a href="../views/view-categorias.php?producto_categoria=Carniceria" class="text-reset">Carnes</a>
          </p>
          <p>
            <a href="../views/view-categorias.php?producto_categoria=Botillería" class="text-reset">Botillería</a>
          </p>
        </div>
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4" style="background-color: rgba(255, 2555, 255)">
          <h6 class="text-uppercase fw-bold mb-4">
            Enlaces
          </h6>
          <p>
            <a href="../views/view-register.php" class="text-reset">Registrarse</a>
          </p>
          <p>
            <a href="../Views/index.php" class="text-reset">Proximamente</a>
          </p>
          <p>
            <a href="../Views/index.php" class="text-reset">Inicio</a>
          </p>
          <p>
            <a href="../views/view-cat-receta.php?" class="text-reset">Recetas</a>
          </p>
        </div>
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4" style="background-color: rgba(255, 255, 255)">
          <h6 class="text-uppercase fw-bold mb-4">Contacto</h6>
          <p><i class="fas fa-home me-3"></i> Juan Fernández 2010, Archipiélago, Curicó, Chile</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            info@ahorrando.cl
          </p>
          <p><i class="fas fa-phone me-3"></i> +56 9 12345678</p>

        </div>
      </div>
    </div>
  </section>
  <div class="text-center p-4" style="background-color: rgba(1, 179, 200);">
    <span>© 2024</span>
    <a class="text-reset fw-bold" href="../Views/index.php">AHORRANDO<i class="fa-solid fa-cart-shopping"></i></a>
  </div>
</footer>

</html>