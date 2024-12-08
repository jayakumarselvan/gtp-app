<?php
    require_once("src/config.php");
    require_once("src/middleware.php");
    require_once("src/auth.php");
    authenticate();
    $users = getUsers();

    $userId = $_SESSION['user']["id"];
    $gaveWishList = getMyGaveWish($userId);


    // w.user_id, w.wish, w.wish_user_id, u.name

    require_once("header.php");
?>
<div class="container">

<table class="table table-bordered">
    <thead>
        <th width="5%">S.No</th>
        <th width="25%">Name</th>
        <th width="60%">Wish</th>
        <th width="10%">Action</th>
    </thead>
    <tbody>
    <?php
        $sNo=0;
        foreach($gaveWishList as $vWish){
            $sNo++;
            $wishId = $vWish["wish_id"];
            $userId = $vWish["user_id"];
            $wish = $vWish["wish"];
            $wishUserId = $vWish["wish_user_id"];
            $wishUserName = $vWish["wish_user_name"];

            ?>
            <tr>
                <td><?=$sNo;?></td>
                <td><?=$wishUserName;?></td>
                <td><?=$wish;?></td>
                <td>
                    <a class="btn btn-primary btn-sm mb-2" href="/give-wish.php?e=<?=$wishId;?>">Edit</a>
                    <a class="btn btn-danger btn-sm mb-2" href="/give-wish.php?d=<?=$wishId;?>" onclick="return confirmAction();">Delete</a>
                </td>
            </tr>
            <?php
        }

    ?>
    </tbody>
</table>
</div>
<script>
function confirmAction() {
    return confirm("Are you sure you want to delete this?");
}

</script>
<?php
require_once("footer.php");
?>