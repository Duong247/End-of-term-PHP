<!-- /templates/layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../templates/assets/images/ITC-icons.webp">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../templates/assets/css/createPost.css">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <title>ITC Blog</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../templates/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/3ecdd9878f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/gi0p1ajd75o5n26qi8ujdhvgxcvvuyyo3yvuu3atelj6oy62/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../../templates/assets/css/createPost.css">
    <link rel="stylesheet" href="../../templates/assets/css/templatemo-stand-blog.css" />
    <link rel="stylesheet" href="../../templates/assets/css/owl.css">
    <link rel="stylesheet" href="../../templates/assets/css/dropdown.css">
    <link rel="stylesheet" href="../../templates/assets/css/fontawesome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <h2>ITC Blog<em>.</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                                               
                        <?php
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        if (isset($_SESSION['user'])) { ?>
                        <li class="nav-item">
                            <div class="btn-group btn-avatar">
                                <a href="#" class="btn dropdown-toggle" aria-expanded="false">
                                    <img class="image-avatar" src="<?= isset($_SESSION['user']['photo']) && $_SESSION['user']['photo']
                                                        ? '/assets/images/photo/' . $_SESSION['user']['photo']
                                                        : '/templates/assets/images/noPhoto.png' ?>" alt="User Avatar">

                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" style="margin-top: 4px;">
                                    <li><a href="/userPostList" class="dropdown-item">Bài viết của tôi</a></li>
                                    <li><a href="/createPost" class="dropdown-item">Tạo bài viết</a></li>
                                    <li><a href="/user/profile" class="dropdown-item">Trang cá nhân</a></li>
                                    <li>
                                        <ul class=" dropdown-menu-end" <?=$_SESSION['user']['role']==0?'hidden':''?>>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a href="/managePosts" class="dropdown-item">Quản lý bài viết</a></li>
                                            <li><a href="/manageCategories" class="dropdown-item">Quản lý thể loại</a></li>
                                            <li><a href="/manageUsers" class="dropdown-item">Quản lý tài khoản</a></li>
                                        </ul>

                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a href="/logout" class="dropdown-item">Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login/index">Đăng nhập</a>
                        </li>
                        <?php } ?>




                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-heading">
        <?= $content ?>
    </div>

    <!-- Include Bootstrap JS and Popper.js via CDN (required for Bootstrap JavaScript features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>