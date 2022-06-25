<div class="p2">
<form method="post" id="edituserform" class="form-wrapper" onsubmit="update(event, this, {{ $data->id }})" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name<sup>*<sup></label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $data->name }}">
        <small id="name_error" class="text-danger"></small>
    </div>
    <div class="form-group">
        <label for="name">Image Profile</label>
        @if ($data->image != '')
        <div>
        <div class="w-50"><img src="/images/{{ $data->image }}" class="img-fluid" /></div>
        </div>
        @endif
        <input type="file" name="image" id="image" class="form-control" placeholder="Name">
        <small id="image_error" class="text-danger"></small>
    </div>
    <div class="form-group mt-2">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <small id="password_error" class="text-danger"></small>
    </div>
    <div class="form-group mt-1">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype Password">
        <small id="password_confirmation_error" class="text-danger"></small>
    </div>
    <div class="form-group mt-2">
        <button class="btn btn-warning btn-submit" type="submit">Update</button>
    </div>
</form>
</div>