<?php ob_start(); ?>
<div class="container">
    <h2 style="padding-bottom: 8px">Quản lý người dùng</h2>

    <hr>

    <form action="manageUser/search" method="POST" class="mb-3">
        <div class="input-group">
            <input type="text" name="searchValue" class="form-control" placeholder="Nhập tên người dùng cần tìm kiếm..." aria-label=""
                aria-describedby="basic-addon1">
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-outline-secondary">Tìm kiếm</button>
            </div> 
        </div>
    </form>


    <table style="background-color: #f5f5f5" class="table mt-3 table-bordered">
        <thead class="table-primary">
            <tr>
                <th style="width: 200px" class="text-center" scope="col">Họ và tên</th>
                <th class="text-center" scope="col">Email</th>
                <th style="width: 200px" class="text-center" scope="col">Thời gian tạo</th>
                <th style="width: 150px" style="width: 180px;" class="text-center" scope="col">Số bài viết đã đăng</th>
                <th class="text-center" scope="col">Vai trò</th>
                <th style="width: 150px;" class="text-center" scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($usersResults)){?>
                <?php foreach ($usersResults as $user) { ?>
                    <tr>
                        <td><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td class="text-center">
                            <?php
                            $uploadTime = new DateTime($user['created_at']);
                            $formattedDate = $uploadTime->format('H:i d/m/Y');
                            echo $formattedDate;
                            ?>
                        </td>
                        <td class="text-center"><?= $user['quantityPosts'] ?></td>
                        <td class="text-center">
                            <?php
                            if ($user['role'] == 1) {
                                echo 'Admin';
                            } else {
                                echo 'Người dùng';
                            }
                            ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button onclick="viewDetailPostsOfUser(<?=$user['id']?>)" type="button" class="btn btn-info" style="margin: 0 4px;" data-toggle="tooltip"
                                    data-placement="top" title="Xem các bài viết của người dùng"><i style="color: #fff"
                                        class="fa fa-navicon"></i></button>
                                <button type="button" class="btn btn-danger" style="margin: 0 4px;" data-toggle="tooltip"
                                    data-placement="top" title="Xóa người dùng"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php }else{?>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td class="text-center">
                            <?php
                            $uploadTime = new DateTime($user['created_at']);
                            $formattedDate = $uploadTime->format('H:i d/m/Y');
                            echo $formattedDate;
                            ?>
                        </td>
                        <td class="text-center"><?= $user['quantityPosts'] ?></td>
                        <td class="text-center">
                            <?php
                            if ($user['role'] == 1) {
                                echo 'Admin';
                            } else {
                                echo 'Người dùng';
                            }
                            ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button onclick="viewDetailPostsOfUser(<?=$user['id']?>)" type="button" class="btn btn-info" style="margin: 0 4px;" data-toggle="tooltip"
                                    data-placement="top" title="Xem các bài viết của người dùng"><i style="color: #fff"
                                        class="fa fa-navicon"></i></button>
                                <button type="button" class="btn btn-danger" style="margin: 0 4px;" data-toggle="tooltip"
                                    data-placement="top" title="Xóa người dùng"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <nav style="display: flex; justify-content: center; color: #000; margin-top: 32px"
        aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a style="color: #000; padding: 12px" class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a style="color: #000; padding: 12px" class="page-link" href="#">1</a></li>
            <li class="page-item"><a style="color: #000; padding: 12px" class="page-link" href="#">2</a></li>
            <li class="page-item"><a style="color: #000; padding: 12px" class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a style="color: #000; padding: 12px" class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<script>
    function viewDetailPostsOfUser(userId) {
        window.location.href = '/manageUser?userId=' +userId
    }
</script>
<?php $content = ob_get_clean(); ?>
<?php
define('BASE_PATH', dirname(__DIR__, 2));
include(BASE_PATH . '/templates/layout.php');
?>