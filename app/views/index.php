<?php
use JasonGrimes\Paginator;
$this->layout('template', ['title' => 'Posts']);
$itemsPerPage = 10;
$currentPage = $_GET['page'] ?? 1;
$urlPattern = '/?page=(:num)';
$paginator = new Paginator($pages, $itemsPerPage, $currentPage, $urlPattern);

?>
<div class="container">


    <h1>All Posts</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
            <td><?= $post['id'] ?></td>
                <td><a href="post/<?= $post['id'] ?>"><?= $post['title'] ?></a></td>
            <td><?= $post['content'] ?></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <?php require '../vendor/jasongrimes/paginator/examples/pager.phtml'; ?>
</div>
