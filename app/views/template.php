<?php global $auth; ?>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title><?= $this->e($title) ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
    <a class="navbar-brand" href="/">My Site</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/signup">Sign Up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/login">Sign In</a>
            </li>
        </ul>
        <div><?= 'Hi, ' . ($auth->getUsername() ?? 'Guest') ?></div>
        <?php if ($auth->hasRole(\Delight\Auth\Role::ADMIN)): ?>
            <a href="/admin" class="btn btn-link">Admin Panel</a>
        <?php endif; ?>
        <?php if ($auth->check()) : ?>
            <a href="/logout" class="btn btn-link">Logout</a>
        <?php endif; ?>
    </div>
</nav>
<?= $this->section('content') ?>

</body>
</html>