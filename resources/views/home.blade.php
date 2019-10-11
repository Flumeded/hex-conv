<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>hex-conv</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    @include('bulma::notifications')
</head>

<body>
<form action="upload" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="section">
        <nav class="level">
            <div class="level-item has-text-centered">
                <div class="file">
                    <label class="file-label">
                        <input class="file-input" type="file" name="firmware">
                        <span class="file-cta">
              <span class="file-icon">
                <i class="fas fa-upload"></i>
              </span>
              <span class="file-label">
                Choose hex…
              </span>
            </span>
                    </label>
                </div>
                <button class="button is-primary" id="convert" type="submit">Convert</button>

            </div>
        </nav>
    </section>
</form>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</body>
</html>






