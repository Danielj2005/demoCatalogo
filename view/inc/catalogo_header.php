<header id="header" class="gap-3 align-items-center d-flex fixed-top header justify-content-between px-3">

    <div class="d-flex align-items-center justify-content-between d-non d-lg-block">
        <a href="./" class="logo d-flex align-items-center">
            <img src="./view/img/<?= LOGO ?>" alt="Logo de <?= COMPANY ?>">
            <span class=""><?= COMPANY ?></span>
        </a>
    </div>


    <div class="search-br w-100">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Buscar Productos..." title="buscador de productos" oninput="handleSearch(this.value)">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <div class="d-flex align-items-center">
        <a href="./login.php" class="nav-link d-flex align-items-center">
            <i class="bi bi-person-circle fs-3"></i>
            <span class="ms-2">Login</span>
        </a>
    </div>
</header>
<div class="msjFormSend"></div>
