<?php $this->layout('template', ['title' => 'Post '.$post['id']]);
global $auth;
?>
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4"><?= $post['title'] ?></h1>
        <p class="lead">Post created at ...</p>
        <hr class="my-4">
        <p><?= $post['content'] ?></p>
        <?php if ($auth->hasRole(\Delight\Auth\Role::ADMIN)): ?>
            <a class="btn btn-primary btn-lg" href="/edit/<?= $post['id'] ?>" role="button">Edit</a>
        <?php endif; ?>
    </div>
</div>