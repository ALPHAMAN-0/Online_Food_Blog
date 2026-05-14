<?php
// food_experience_comments model

class FoodComment {
    private $pdo;
    function __construct($pdo) { $this->pdo = $pdo; }

    function create($post_id, $user_id, $comment) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO food_experience_comments (post_id, user_id, comment) VALUES (?, ?, ?)"
        );
        $stmt->execute([$post_id, $user_id, $comment]);
        return $this->pdo->lastInsertId();
    }

    function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM food_experience_comments WHERE id=?");
        $stmt->execute([$id]);
    }

    function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM food_experience_comments WHERE id=? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function by_post($post_id) {
        $sql = "SELECT c.*, u.name AS author
                FROM food_experience_comments c
                JOIN users u ON u.id = c.user_id
                WHERE c.post_id = ?
                ORDER BY c.created_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    }

    function owned_by($id, $user_id) {
        $stmt = $this->pdo->prepare("SELECT 1 FROM food_experience_comments WHERE id=? AND user_id=?");
        $stmt->execute([$id, $user_id]);
        return (bool)$stmt->fetch();
    }
}
