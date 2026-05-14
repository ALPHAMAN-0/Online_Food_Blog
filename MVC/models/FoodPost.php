<?php
// food_experience_posts model

class FoodPost {
    private $pdo;
    function __construct($pdo) { $this->pdo = $pdo; }

    function create($user_id, $title, $content, $post_type, $restaurant_id = null, $menu_item_id = null) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO food_experience_posts
             (user_id, title, content, post_type, restaurant_id, menu_item_id)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$user_id, $title, $content, $post_type, $restaurant_id, $menu_item_id]);
        return $this->pdo->lastInsertId();
    }

    function update($id, $title, $content, $post_type, $restaurant_id = null, $menu_item_id = null) {
        $stmt = $this->pdo->prepare(
            "UPDATE food_experience_posts
             SET title=?, content=?, post_type=?, restaurant_id=?, menu_item_id=?
             WHERE id=?"
        );
        $stmt->execute([$title, $content, $post_type, $restaurant_id, $menu_item_id, $id]);
    }

    function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM food_experience_posts WHERE id=?");
        $stmt->execute([$id]);
    }

    function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM food_experience_posts WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function find_with_author($id) {
        $sql = "SELECT p.*, u.name AS author, r.name AS restaurant_name, m.name AS menu_item_name
                FROM food_experience_posts p
                JOIN users u ON u.id = p.user_id
                LEFT JOIN restaurants r ON r.id = p.restaurant_id
                LEFT JOIN menu_items m  ON m.id = p.menu_item_id
                WHERE p.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function all_with_author() {
        $sql = "SELECT p.*, u.name AS author, r.name AS restaurant_name, m.name AS menu_item_name
                FROM food_experience_posts p
                JOIN users u ON u.id = p.user_id
                LEFT JOIN restaurants r ON r.id = p.restaurant_id
                LEFT JOIN menu_items m  ON m.id = p.menu_item_id
                ORDER BY p.created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    function owned_by($id, $user_id) {
        $stmt = $this->pdo->prepare("SELECT 1 FROM food_experience_posts WHERE id=? AND user_id=?");
        $stmt->execute([$id, $user_id]);
        return (bool)$stmt->fetch();
    }

    function count_all() {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM food_experience_posts")->fetchColumn();
    }
}
