<?php
// restaurant_reviews table model (comments on restaurants)

class RestaurantReview {
    private $pdo;
    function __construct($pdo) { $this->pdo = $pdo; }

    function create($restaurant_id, $user_id, $comment) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO restaurant_reviews (restaurant_id, user_id, comment) VALUES (?, ?, ?)"
        );
        $stmt->execute([$restaurant_id, $user_id, $comment]);
        return $this->pdo->lastInsertId();
    }

    function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM restaurant_reviews WHERE id=?");
        $stmt->execute([$id]);
    }

    function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM restaurant_reviews WHERE id=? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function by_restaurant($restaurant_id) {
        $sql = "SELECT r.*, u.name AS author
                FROM restaurant_reviews r
                JOIN users u ON u.id = r.user_id
                WHERE r.restaurant_id = ?
                ORDER BY r.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$restaurant_id]);
        return $stmt->fetchAll();
    }

    function owned_by($id, $user_id) {
        $stmt = $this->pdo->prepare("SELECT 1 FROM restaurant_reviews WHERE id=? AND user_id=?");
        $stmt->execute([$id, $user_id]);
        return (bool)$stmt->fetch();
    }

    function count_all() {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM restaurant_reviews")->fetchColumn();
    }
}
