
<?php 
$tasas_cotizacion = modeloPrincipal::obtener_precio_dolar();
?>
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-around">
    <a href="./" class="logo d-flex align-items-center">
      <img src="img/<?= LOGO ?>" alt="">
      <span class="d-none d-lg-block"><?= COMPANY ?></span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
    <?php //if ($_SESSION['dataUsuario']["primer_inicio"] == '0') { ?>
    <?php //} ?>

  </div>


  <div class="search-bar">
    <form method="POST" action="#" class="search-form d-flex align-items-center position-relative">
      <div class="align-items-center bg-body-secondary bg-opacity-75 d-flex h-100 justify-content-center position-absolute start-0 w-100">
          <i class="bi bi-lock-fill"></i>
      </div>
      <input type="text" name="query" placeholder="Buscar productos..." title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div> 

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item dropdown">

        <button class="btn bg-secondary-light nav-icon fst-italic fs-6" data-bs-toggle="dropdown">
          <i class="bi bi-currency-exchange"></i>
          &nbsp; Tasa USD: <span id="tasa_dolar"><?= $tasas_cotizacion['USD'] ?></span>Bs
        </button>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header row justify-content-center">
            <h6 class="text-center mb-3">Opciones de Actualización</h6>
            <div class=" col-12 mb-2">
              <button id="btn_update_dolar_auto" class="w-100 btn btn-success text-center">
                <i class="bi bi-arrow-repeat"></i>
                <span class="p-2 ms-2">Sincronizar Tasa (Automático)</span>
              </button>
            </div>
            <div class=" col-12 mb-2">
              <button class="btn btn-warning text-center w-100" data-bs-toggle="modal" data-bs-target="#dolarUpdate" id="btnUpdate">
                <i class="bi bi-pencil-square"></i>
                <span class="p-2 ms-2">Establecer Tasa (Manual)</span>
              </button>
            </div>
          </li>
        </ul>
      </li>

      <li class="nav-item dropdown pe-3">

        <button class="nav-link nav-profile d-flex align-items-center pe-0" data-bs-toggle="dropdown">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['dataUser']['nombre']; ?></span>
        </button>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6><?= $_SESSION['dataUser']['nombre']; ?></h6>
            <span><?= $_SESSION['dataUser']['rol'] == 1 ? 'Dev Master' : 'usuario Demo'; ?></span>
          </li>

          <li> <hr class="dropdown-divider"> </li>

          <li class="position-relative">
            <div class="align-items-center bg-body-secondary bg-opacity-75 d-flex h-100 justify-content-center position-absolute start-0 w-100">
                <i class="bi bi-lock-fill"></i>
            </div>
            <a class="dropdown-item d-flex align-items-center" href="./mi_perfil.php">
              <i class="bi bi-person"></i>
              <span>Mi Pefil</span>
            </a>
          </li>

          <li> <hr class="dropdown-divider"> </li>

          <?php 
            // Lista de todos los permisos que pertenecen al Módulo de Configuración/Ajustes

            // $permiso_ajustes = modeloPrincipal::verificar_permisos_requeridos($_SESSION['permisosRequeridos']['ajustes']);

            // se evalua que este rol tenga el acceso a esta vista

            // if ($permiso_ajustes) { ?>
            
            
            <?php //}  ?>
            <li class="position-relative">
            <div class="align-items-center bg-body-secondary bg-opacity-75 d-flex h-100 justify-content-center position-absolute start-0 w-100">
                <i class="bi bi-lock-fill"></i>
            </div>
              <a class="dropdown-item d-flex align-items-center" href="./configuracion.php">
                <i class="bi bi-gear-fill"></i>
                <span>Configuración</span>
              </a>
            </li>

          <li> <hr class="dropdown-divider"> </li>

          <li>
            <a class="dropdown-item d-flex align-items-center btn-exit-system" href="#!">
              <i class="bi bi-box-arrow-right"></i>
              <span>Cerrar Sesión</span>
            </a>
          </li>

        </ul>
      </li>
    </ul>
  </nav>
</header>
<div class="msjFormSend"></div>
