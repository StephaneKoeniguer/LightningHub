<?php

namespace App\Controllers;


use App\Models\Filters;
use App\Models\Room;

class RoomsController
{
    const URL_CREATE = '/hub.php';
    const URL_INDEX = '/hub.php';
    const URL_HANDLER = '/handlers/product-handler.php';
    
    public function create()
    {
        $index = self::URL_CREATE;
        if (empty($_POST['room_title']) or empty($_POST['room_game_type'])) {
            header("Location: $index");
            exit();
        }

        $idUser = $_SESSION["id"];
        $title = $_POST["room_title"];
        $description = $_POST["description"] ?? "";
        $maxMembers = intval($_POST["room_number_player"] ?: 5);
        $game = $_POST["room_game"];
        $gamemode = $_POST["room_game_type"];

        $filters = new Filters;
        $gamemodeId = $filters->getGamemodeId($game, $gamemode);

        // Insert the room in DB
        Room::createNewRoom($idUser, $title, $description, $maxMembers, $gamemodeId);

        header("Location: $index");
        exit();
    }

    public function modify()
    {
        $index = self::URL_INDEX;
        if (empty($_POST["room_id"] or empty($_POST['room_game_type_id']) or empty($_POST['room_title']))) {
            header("Location: $index");
            exit();
        }

        // TODO check if the user sending the request is the room owner

        $idRoom = $_POST["room_id"];
        $title = $_POST["room_title"];
        $description = $_POST["description"] ?? "";
        $maxMembers = intval($_POST["room_number_player"] ?: 5);
        $gamemodeId = $_POST["room_game_type_id"];

        // Update the room in DB
        Room::modifyRoom($idRoom, $title, $description, $maxMembers, $gamemodeId);

        header("Location: $index");
        exit();
    }

    public function delete()
    {
        $index = self::URL_INDEX;
        if (empty($_POST["room_id"])) {
            header("Location: $index");
            exit();
        }

        // TODO check if the user sending the request is the room owner

        $idRoom = $_POST["room_id"];

        // Delete the room in DB
        Room::deleteRoom($idRoom);

        header("Location: $index");
        exit();
    }
    
    public function leave()
    {
        $index = self::URL_INDEX;
        if (empty($_SESSION["id"])) {
            header("Location: $index");
            exit();
        }

        $idUser = $_SESSION["id"];

        // Delete the room in DB
        Room::leaveRoom($idUser);

        header("Location: $index");
        exit();
    }
}

?>
