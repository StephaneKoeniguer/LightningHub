<?php

namespace App\Controllers;


require_once __DIR__ . '/../Models/Social.php';
require_once __DIR__ . '/../Models/User.php';

use Auth;
use DB;
use App\Models\Social;
use App\Models\User;


// use Models\Social;

class SocialsController
{
    const URL_CREATE = '/social-create.php';
    const URL_INDEX = '/socials.php';
    const URL_HANDLER_MSG = '/handlers/messages-handler.php';
    const URL_HANDLER_SOC = '/handlers/socials-handler.php';

    public function index()
    {

        $friends = $this->getFriends();
        $friendsNames = $this->getMyFriendsNames();
        // FRIENDS LIST TAB
        $friends_connected = $this->getConnectedFriends();
        $friends_disconnected = $this->getDisconnectedFriends();

        // Hydrate products
//        foreach ($friends_disconnected as $key => $friend_disconnected) {
//            $friends_disconnected[$key] = User::hydrate($friend_disconnected);
//        }
        //dd($friends_disconnected);

        $current_user = Auth::getCurrentUser();
        // FRIENDS REQUESTS LIST TAB
        $requests = $this->getFriendRequests();

        // MESSAGES
        $myMsgs = $this->getMyMsgs();

        $actionUrlSoc = self::URL_HANDLER_SOC;
        $actionUrlMsg = self::URL_HANDLER_MSG;
        require_once base_path('view/socials/index.php');
    }

    public function create()
    {
        $actionUrl = self::URL_HANDLER;
        $defaultVat = Product::DEFAULT_VAT;
        require_once base_path('view/products/create.php');
    }

    public function store()
    {
        //dd($_POST);
        $myId = 1;// Auth::getSessionUserId();
        if (!$_POST['searchFriend']) {
            errors('Veuillez entrer un nom');
            redirectAndExit(self::URL_CREATE);
        }

        // La il faut un getUserByName(string $username)
        $user = DB::fetch(
            "SELECT * FROM users WHERE username = :username",
            ['username' => $_POST['searchFriend']]
        );
        if ($user === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }
        if (empty($user)) {
            errors('404. Page introuvable');
            redirectAndExit(self::URL_INDEX);
        }

        // dd($user[0]);


        $social = new Social(
            $myId ?? null,
            $user[0]['idUser'] ?? null,
            0 ?? null
        );


        // Save the product in DB
        $social->insert();

        redirectAndExit(self::URL_INDEX);
    }

//    public function delete()
//    {
//        $id = $_GET['id'] ?? null;
//
//        if (!$id) {
//            errors('Identifiant invalide');
//            redirectAndExit(self::URL_INDEX);
//        }
//
//        // Delete a product in DB
//        Social::staticDelete($id);
//
//        redirectAndExit(self::URL_INDEX);
//    }

    public function delete()
    {
        $idUser = $_POST['id'] ?? null;
        $social = $this->getSocialByFriend($idUser);
        //dd($social);
        // Delete a product in DB
        $social->delete();

        redirectAndExit(self::URL_INDEX);
    }

    protected function getSocialByFriend(?int $idFriend): Social
    {
        if (!$idFriend) {
            errors('404. Page introuvable');
            redirectAndExit(self::URL_INDEX);
        }
        $myId = 1; // A changer
        $product = DB::fetch(
            "SELECT * FROM isfriend WHERE idUser1 = :myId and idUser2 = :idFriend or idUser1 = :idFriend and idUser2 = :myId",
            ['myId' => $myId, 'idFriend' => $idFriend]
        );
        if ($product === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }
        if (empty($product)) {
            errors('404. Page introuvable');
            redirectAndExit(self::URL_INDEX);
        }
        return Social::hydrate($product[0]);
    }


    public function getConnectedFriends()
    {
        $friendsID = $this->getFriendsId();
        $friendsConnected = DB::fetch(
        // SQL
            "SELECT * FROM users"
            . " WHERE users.idUser IN (" . $friendsID . ")"
            . " AND TIMESTAMPDIFF(MINUTE, lastConnection, NOW()) <= 5"
            . " ORDER BY SignUpDate DESC",


        );
        if ($friendsConnected === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }

        return $friendsConnected;
    }

//    public function getDisconnectedFriends() {
//        //$userId = Auth::getSessionUserId();
//        $userId = 1;
//
//        $friends_disconnected = DB::fetch(
//        // SQL
//            "SELECT * FROM users"
//            ." INNER JOIN isfriend ON users.idUser = isfriend.idUser1"
//            ." WHERE isfriend.idUser2 = :user_id"
//            ." AND accepted = 1"
//            ." AND TIMESTAMPDIFF(MINUTE, lastConnection, NOW()) > 5"
//            ." ORDER BY SignUpDate DESC",
//
//            // Params
//            [':user_id' => $userId],
//
//        );
//        if ($friends_disconnected === false) {
//            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
//            redirectAndExit(self::URL_INDEX);
//        }
//        return $friends_disconnected;
//    }

    public function getDisconnectedFriends()
    {

        $friendsID = $this->getFriendsId();
        $friendsDisconnected = DB::fetch(
        // SQL
            "SELECT * FROM users"
            . " WHERE users.idUser IN (" . $friendsID . ")"
            . " AND TIMESTAMPDIFF(MINUTE, lastConnection, NOW()) > 5"
            . " ORDER BY SignUpDate DESC",


        );
        if ($friendsDisconnected === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }

        return $friendsDisconnected;
    }

    public function getFriendRequests()
    {
        //$userId = Auth::getSessionUserId();
        $userId = 1;

        $requests = DB::fetch(
        // SQL
            "SELECT * FROM users"
            . " INNER JOIN isfriend ON users.idUser = isfriend.idUser1"
            . " WHERE isfriend.idUser2 = :user_id"
            . " AND accepted = 0",

            // Params
            [':user_id' => $userId],

        );
        if ($requests === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }
        return $requests;
    }

    public static function getFriendsId()
    {
        //$userId = Auth::getSessionUserId();
        $userId = 1;

        $friendsId = DB::fetch(
        // SQL
            "SELECT * FROM isfriend"
            . " WHERE (isfriend.idUser1 = :user_id OR isfriend.idUser2 = :user_id)"
            . " AND accepted = 1",

            // Params
            [':user_id' => $userId],

        );
        if ($friendsId === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }

        $tempFriendList = [];
        foreach ($friendsId as $friendId) {
            if ($friendId["idUser1"] === $userId) {
                array_push($tempFriendList, $friendId["idUser2"]);
            } else {
                array_push($tempFriendList, $friendId["idUser1"]);
            }
        }

        return "'" . implode("', '", $tempFriendList) . "'";
    }

    public function getFriends()
    {
        $friendsID = $this->getFriendsId();
        $friends = DB::fetch(
        // SQL
            "SELECT * FROM users"
            . " WHERE users.idUser IN (" . $friendsID . ")",
        );
        if ($friends === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }

        return $friends;
    }

    public function getMyMsgs()
    {
        //$userId = Auth::getSessionUserId();
        $userId = 1;

        $myMsgs = DB::fetch(
        // SQL
            "SELECT * FROM sendprivatemessages"
            . " INNER JOIN users ON users.idUser = sendprivatemessages.idUser1"
            . " WHERE (sendprivatemessages.idUser1 = :user_id OR sendprivatemessages.idUser2 = :user_id)"
            . " ORDER BY sendprivatemessages.timeMessage",

            // Params
            [':user_id' => $userId],

        );
        if ($myMsgs === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }
        return $myMsgs;

    }

    public function acceptRequest()
    {
        //$userId = Auth::getSessionUserId();
        $userId = 1;


    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $product = $this->getSocialByFriend($id);

        if (isset($_POST['accepted'])) {
            $product->setAccepted($_POST['accepted'] == 1 ? 1 : 0);
        }

        // Update the product in DB
        $result = $product->save();
        if ($result === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
        } else {
            success('Le produit a bien été modifié.');
        }

        // redirectAndExit(self::URL_EDIT.'?id='.$product->getId());
    }

    public function getMyFriendsNames(): string
    {
        $friends = self::getFriends();
        $usernames = [];
        foreach ($friends as $t) {
            $usernames[] = $t['username']; // like array_push
        }
        return implode(',', $usernames);
    }

    /// JE CHERCHE PAS DANS LES BONS TRUCS ::> faut trouver dans les non amis
    public function getUsers(): array
    {
        $requests = DB::fetch(
        // SQL
            "SELECT * FROM users"
            . " INNER JOIN isfriend ON users.idUser = isfriend.idUser1"
            . " WHERE isfriend.idUser2 = :user_id"
            . " AND accepted = 0",

            // Params
            [':user_id' => $userId],

        );
        if ($requests === false) {
            errors('Une erreur est survenue. Veuillez ré-essayer plus tard.');
            redirectAndExit(self::URL_INDEX);
        }
        return $requests;
    }

}