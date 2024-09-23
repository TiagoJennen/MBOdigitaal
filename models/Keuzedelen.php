<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/docroot.php';
require_once __DOCUMENTROOT__ . '/config/globalvars.php';
require_once __DOCUMENTROOT__ . '/errors/default.php';
require_once __DOCUMENTROOT__ . '/database/dbconnection.php';
require_once __DOCUMENTROOT__ . '/vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class Keuzedeel
{
    // insert voegt één nieuw keuzedeel toe aan de tabel keuzedeel.
    // Er wordt een UUIDv4 gegeneerd als unieke ID.
    public static function insert(
        $code,
        $title,
        $sbu,
        $description,
        $goalsDescription,
        $preconditions,
        $teachingMethods,
        $certificate,
        $linkVideo,
        $linkKD
    ) {
        global $db;

        // Generate a version 4 (random) UUID
        $keuzedeelId = Uuid::uuid4();

        $sql_insert_into_keuzedeel = "INSERT INTO keuzedeel (id, code, title, sbu, description, goalsDescription, preconditions, teachingMethods, certificate, linkVideo, linkKD)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $db->prepare($sql_insert_into_keuzedeel);

        if (
            $stmt->execute([
                $keuzedeelId,
                $code,
                $title,
                $sbu,
                $description == "" ? null : $description,
                $goalsDescription == "" ? null : $goalsDescription,
                $preconditions == "" ? null : $preconditions,
                $teachingMethods == "" ? null : $teachingMethods,
                $certificate,
                $linkVideo == "" ? null : $linkVideo,
                $linkKD == "" ? null : $linkKD
            ])
        ) {
            return true;
        } else {
            return false;
        }
    }

    // select selecteert één keuzedeel op basis van een gegeven id.
    public static function select($id)
    {
        global $db;

        $sql_select_keuzedeel_by_id = "SELECT * FROM keuzedeel WHERE id=?;";

        $stmt = $db->prepare($sql_select_keuzedeel_by_id);

        if ($stmt->execute([$id])) {
            $keuzedelen = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($keuzedelen as $keuzedeel) {
                return $keuzedeel;
            }
        }
    }

    // selectAll selecteert alle keuzedelen geordend op code.
    public static function selectAll()
    {
        global $db;

        $sql_selectAll_keuzedelen = "SELECT * FROM keuzedeel ORDER by code;";

        $stmt = $db->prepare($sql_selectAll_keuzedelen);

        if ($stmt->execute()) {
            $keuzedelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $keuzedelen;
        }
    }

    // update werkt de informatie van een record van een bepaalde id bij.
    public static function update(
        $id,
        $code,
        $title,
        $sbu,
        $description,
        $goalsDescription,
        $preconditions,
        $teachingMethods,
        $certificate,
        $linkVideo,
        $linkKD
    ) {
        global $db;

        $sql_update_keuzedeel_by_id = "UPDATE keuzedeel
        SET code=?, title=?, sbu=?, description=?, goalsDescription=?, preconditions=?, teachingMethods=?, certificate=?, linkVideo=?, linkKD=?
        WHERE id=?";

        $stmt = $db->prepare($sql_update_keuzedeel_by_id);

        if (
            $stmt->execute([
                $code,
                $title,
                $sbu,
                $description == "" ? null : $description,
                $goalsDescription == "" ? null : $goalsDescription,
                $preconditions == "" ? null : $preconditions,
                $teachingMethods == "" ? null : $teachingMethods,
                $certificate,
                $linkVideo == "" ? null : $linkVideo,
                $linkKD == "" ? null : $linkKD,
                $id
            ])
        ) {
            return true;
        } else {
            return false;
        }
    }

    // delete verwijdert een record uit de tabel keuzedeel met een bepaald id.
    public static function delete($id)
    {
        global $db;

        $sql_delete_keuzedeel_by_id = "DELETE FROM keuzedeel WHERE id=?;";
        $stmt = $db->prepare($sql_delete_keuzedeel_by_id);
        if ($stmt->execute([$id])) {
            return true;
        } else {
            return false;
        }
    }
}
