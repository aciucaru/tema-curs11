<?php ?>

<style>
<?php include './styles/navbar.css'; ?>
</style>

<nav class="navbar">
    <div class="navbar-item">
        <a class="navbar-link" href="./produse.php">Produse</a>
    </div>

    <?php if(isset($_SESSION['username']) and !empty($_SESSION['username'])): ?>
        <div class="navbar-item">
            <a class="navbar-link" href="#">
                Contul meu
            </a>
        </div>
    <?php else: ?>
        <div class="navbar-item ">
            <a class="navbar-link" href="./login.php">Login</a>
        </div>

        <div class="navbar-item">
            <a class="navbar-link" href="./register.php">Inregistrare</a>
        </div>
    <?php endif ?>

    <div class="navbar-item">
        <a class="navbar-link" href="./cosul-meu.php">Cos</a>
    </div>
</nav>