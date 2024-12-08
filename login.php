<?php
require 'src/config.php';
require 'src/auth.php';

if (isset($_GET['code'])) {
    $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
        throw new Exception('Error fetching token: ' . $token['error']);
    }
    $googleClient->setAccessToken($token);
    $oauth2 = new Google\Service\Oauth2($googleClient);
    $googleUser = $oauth2->userinfo->get();
    // echo "User Email: " . $googleUser->email;
    // echo "User Name: " . $googleUser->name;
    $user = getUserByEmail($googleUser->email);
    if (!$user) {
        echo "Access denied. You are not registered.";
        exit();
    }
    $_SESSION['user'] = $user;
    header('Location: index.php');
    exit();
}
$loginUrl = $googleClient->createAuthUrl();
?>
<?php
    require_once("header.php");
?>
<div class="container">

    <h1>Login with Google</h1>
    <a href="<?= htmlspecialchars($loginUrl) ?>">Login with Google</a>

</div>
<?php
require_once("footer.php");
?>
