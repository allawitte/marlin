<?php $this->layout('template', ['title' => 'Post '.$post['id']]); ?>
<div class="container">
    <form method="post" action="/edit/<?= $post['id'] ?>">
        <div class="form-group">
            <label for="title">Post title</label>
            <input type="text" class="form-control" id="title" placeholder="post title" name="title" value="<?= $post['title'] ?>">
        </div>
        <div class="form-group">
            <label for="content">Post Content</label>
            <textarea class="form-control" id="content" placeholder="Post Content" name="content"><?= $post['content'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
