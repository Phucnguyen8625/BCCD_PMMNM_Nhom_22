<?php
require_once 'config/database.php';
$db = (new Database())->getConnection();

try {
    // 1. Drop foreign key constraint first
    // We need to find the constraint name. Usually it's 'comics_ibfk_1' based on the error message.
    $db->exec("ALTER TABLE comics DROP FOREIGN KEY comics_ibfk_1");
    echo "Dropped foreign key 'comics_ibfk_1'.\n";

    // 2. Make category_id nullable or just drop it
    $db->exec("ALTER TABLE comics MODIFY category_id INT NULL");
    echo "Made 'category_id' nullable.\n";

    // Optional: actually drop the column if we are sure all code is updated
    // $db->exec("ALTER TABLE comics DROP COLUMN category_id");
    // echo "Dropped column 'category_id'.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    // If it fails because of name mismatch, try to find the constraint
    try {
        echo "Attempting to find constraint name...\n";
        $result = $db->query("SHOW CREATE TABLE comics")->fetch();
        $createSql = $result['Create Table'];
        if (preg_match('/CONSTRAINT `([^`]+)` FOREIGN KEY \(`category_id`\)/', $createSql, $matches)) {
            $constraintName = $matches[1];
            $db->exec("ALTER TABLE comics DROP FOREIGN KEY $constraintName");
            echo "Dropped foreign key '$constraintName'.\n";
            $db->exec("ALTER TABLE comics MODIFY category_id INT NULL");
            echo "Made 'category_id' nullable.\n";
        }
    } catch (Exception $e2) {
        echo "Secondary error: " . $e2->getMessage() . "\n";
    }
}
