<?php
require_once 'config.php';

function getUserByEmail($email) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([trim($email)]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createUser($googleUser) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (name, email, google_id, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$googleUser['name'], $googleUser['email'], $googleUser['id'], 'user']);
}

function isAdmin(   ) {
    return $_SESSION['user']['role'] === 'admin';
}

function getUsers(){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users order by name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addWish($userId, $wishUserId, $wish){
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO wish (`year`, user_id, wish_user_id, wish) VALUES ('2025',?, ?, ?)");
    $stmt->execute([$userId, $wishUserId, $wish]);
}

function updateWish($userId, $wishUserId, $wish, $wishId){
    global $pdo;
    $stmt = $pdo->prepare("UPDATE wish set wish_user_id=?, wish=? where id=? and user_id=?");
    $stmt->execute([$wishUserId, $wish, $wishId, $userId]);
}


function deleteWish($userId, $wishId){
    global $pdo;
    $stmt = $pdo->prepare("delete from wish where id=? and user_id=?");
    $stmt->execute([$wishId, $userId]);
}

function getMyGaveWish($userId){
    global $pdo;
    $stmt = $pdo->prepare("select w.id as wish_id, w.user_id, w.wish, w.wish_user_id, u.name as wish_user_name from wish as w left join users as u on u.id = w.wish_user_id where w.user_id=?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isLoggedIn(){
    if (isset($_SESSION['user'])) {
        return true;
    }else{
        return false;
    }
}

function getWish($userId, $wishId){
    global $pdo;
    $stmt = $pdo->prepare("select * from wish where user_id=? and id=?");
    $stmt->execute([$userId, $wishId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMyReceivedWishList($wishUserId){
    global $pdo;
    $stmt = $pdo->prepare("select w.id as wish_id, w.user_id, w.wish, w.wish_user_id, u.name as user_name from wish as w left join users as u on u.id = w.user_id where w.wish_user_id=?");
    $stmt->execute([$wishUserId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
