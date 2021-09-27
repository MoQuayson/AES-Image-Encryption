<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AES Image Encryption</title>

    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css');}}">
    <script src="{{asset('bootstrap/js/bootstrap.min.js');}}"></script>
</head>
<body>
    <div class="container mt-3 m-auto">
        <h1 class="mb-5 text-center">AES Image Encryption</h1>
        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3 w-75 m-auto" role="alert">
                {{Session::get('success')}}
                <button id="close" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (Session::get('fail'))
            <div class="alert alert-danger alert-dismissible fade show mb-3 w-75 m-auto" role="alert">
                {{Session::get('fail')}}
                <button id="close" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col">
                <div class="card m-auto" style="max-width: 800px">
                    <div class="card-header py-3 text-primary">
                        <h5>Image Encryption</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <form action="/" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="container">
                                        <div class="col mb-3">
                                            <h5 class="text-black-50 fw-bold mb-4">Upload Image and provide key below</h5>
                                            <label class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/x-png,image/jpeg,image/jpg" aria-describedby="button-addon2" onchange="UploadImage(this.files)">
                                            <span style="color:red">@error('image'){{$message}}@enderror</span>
                                        </div>

                                        <div class="col mb-3">
                                            <label class="form-label">Encrypted Key</label>
                                            <div class="input-group">
                                                <input class="form-control" id="encrypt_key" name="encrypt_key" placeholder="Encrypt Key Here" aria-describedby="button-addon2">
                                                <button class="btn btn-success" type="submit" id="button-addon2">Encrypt Photo</button>
                                            </div>
                                            <span style="color:red">@error('encrypt_key'){{$message}}@enderror</span>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-sm-4">
                                <h5>Photo to Encrypt: </h5>
                                <img id="photo" class="img-fluid mt-1" width="200" height="200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col text-center mt-3">
            <p style="font-size: 22px;">To decrypt and show Image, Click <a href="/decryption">Here</a></p>
        </div>
    <script>
        function UploadImage(file){
            document.getElementById('photo').src = window.URL.createObjectURL(file[0]);
        }
    </script>
</body>
</html>
