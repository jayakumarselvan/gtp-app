<?php
    require_once("src/config.php");
    require_once("src/middleware.php");
    require_once("src/auth.php");
    authenticate();
    authorizeAdmin();
    $users = getUsers();
    require_once("header.php");
?>
<div class="container">

    <table class="table table-bordered">
        <thead>
            <th>S.No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </thead>
        <tbody>
        <?php
            $sNo=0;
            foreach($users as $user){
                $sNo++;
                $id = $user["id"];
                $name = $user["name"];
                $email = $user["email"];
                $role = $user["role"];

                ?>
                <tr>
                    <td><?=$sNo;?></td>
                    <td><?=$name;?></td>
                    <td><?=$email;?></td>
                    <td><a class="btn btn-primary btn-sm" href="/user-wish.php?userId=<?=$id;?>">Wishes</a></td>
                </tr>
                <?php
            }

        ?>
        </tbody>
    </table>
</div>
<?php
require_once("footer.php");
?>