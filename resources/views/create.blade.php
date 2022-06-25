<div class="p2">
<form method="post" id="adduserform" class="form-wrapper" onsubmit="store(event, this)" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name<sup>*<sup></label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
        <small id="name_error" class="text-danger"></small>
    </div>
    <div class="form-group mt-2">
        <label for="email">Email<sup>*<sup></label>
        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
        <small id="email_error" class="text-danger"></small>
    </div>
    <div class="form-group mt-2">
        <label for="password">Password<sup>*<sup></label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <small id="password_error" class="text-danger"></small>
    </div>
    <div class="form-group mt-1">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype Password">
        <small id="password_confirmation_error" class="text-danger"></small>
    </div>
    <div class="form-group">
        <label for="name">Image Profile</label>
        <input type="file" name="image" id="image" class="form-control" placeholder="Name">
        <small id="image_error" class="text-danger"></small>
    </div>
    <div class="form-group mt-4">
        <button class="btn btn-success btn-submit">Create</button>
    </div>
</form>
</div>