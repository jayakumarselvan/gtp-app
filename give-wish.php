<?php
    require_once("src/config.php");
    require_once("src/middleware.php");
    require_once("src/auth.php");
    authenticate();
    $userId = $_SESSION['user']["id"];
    $users = getUsers();

    $wishUserId = "";
    $wishValue = "";
    $editId = "";

    if ( isset($_GET) && !empty($_GET) ){
        if ( isset($_GET["e"]) && !empty($_GET["e"]) ){
            $editId = $_GET["e"];
            $editWish = getWish($userId, $editId);
            if ( !empty($editWish) && isset($editWish[0]) && !empty($editWish[0])){
                $wishUserId = $editWish[0]["wish_user_id"];
                $wishValue = $editWish[0]["wish"];
            }
        }


        if ( isset($_GET["d"]) && !empty($_GET["d"]) ){
            $deleteId = $_GET["d"];
            deleteWish($userId, $deleteId);
            header('Location: give-wishlist.php');
        }

        
    }

    if ( isset($_POST) && !empty($_POST)){
        $wishUserId = $_POST["wishUserId"];
        $wish = $_POST["wish"];

        if ( isset($_POST["wishId"]) && !empty($_POST["wishId"]) ){
            $wishId = $_POST["wishId"];
            updateWish($userId, $wishUserId, $wish, $wishId);

        }else{
            addWish($userId, $wishUserId, $wish);
        }

        header('Location: give-wishlist.php');
    }



    require_once("header.php");
?>
<div class="container">

<form action="" method="post">
    <div class="form-floating">
        <select class="form-control" name="wishUserId" id="wishUserId">
            <option value="">Select the user</option>
            <?php
                foreach($users as $user){
                    $id = $user["id"];
                    $name = $user["name"];

                    if ($userId != $id){
                        $selectedStr = "";
                        if ( $id == $wishUserId ){
                            $selectedStr = ' selected="selected" ';
                        }

                        echo '<option value="'.$id.'" '.$selectedStr.' >'.$name.'</option>';
                    }

                    
                }
            ?>
        </select>
        <label for="wishUserId">User</label>
    </div>
    <div class="form-floating mt-3">
        <textarea class="form-control" placeholder="Enter your wish" id="wish"  name="wish" style="height: 200px"><?=$wishValue;?></textarea>
        <label for="wish">Your Wish</label>
    </div>
    <div class="form-floating mt-3">
        <input type="hidden" name="wishId" value="<?=$editId;?>">
        <button type="submit" class="btn btn-primary">Submit</button>                
    </div>
</form>

</div>
<?php
require_once("footer.php");
?>