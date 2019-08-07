<?php $this->layout('template', ['title' => 'Sing Up']) ?>
<div class="container">
    <div><?= $flash ?></div>
    <form method="POST" action="/signup">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="email">Username</label>
            <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter email" name="username">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="pass">Password</label>
            <input type="password" class="form-control" id="pass" placeholder="Password" name="password">
        </div>
        <!--div class="form-group">
            <label for="repeat">Repeat password</label>
            <input type="password" class="form-control" id="repeat" placeholder="Password">
        </div-->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
