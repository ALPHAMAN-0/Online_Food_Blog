<?php
// reviews table model (comments on food items)

class Review {
    private $pdo;
    function __construct($pdo) { $this->pdo = $pdo; }

    function create($menu_item_id, $user_id, $comment) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO reviews (menu_item_id, user_id, comment) VALUES (?, ?, ?)"
        );
        $stmt->execute([$menu_item_id, $user_id, $comment]);
        return $this->pdo->lastInsertId();
    }

    function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE id=?");
        $stmt->execute([$id]);
    }

    function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reviews WHERE id=? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function by_menu_item($menu_item_id) {
        $sql = "SELECT r.*, u.name AS author
                FROM reviews r
                JOIN users u ON u.id = r.user_id
                WHERE r.menu_item_id = ?
                ORDER BY r.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$menu_item_id]);
        return $stmt->fetchAll();
    }

    function owned_by($id, $user_id) {
        $stmt = $this->pdo->prepare("SELECT 1 FROM reviews WHERE id=? AND user_id=?");
        $stmt->execute([$id, $user_id]);
        return (bool)$stmt->fetch();
    }

    function count_all() {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
    }
}
