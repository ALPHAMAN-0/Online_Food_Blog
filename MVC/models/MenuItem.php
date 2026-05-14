<?php
// menu_items table model

class MenuItem {
    private $pdo;
    function __construct($pdo) { $this->pdo = $pdo; }

    function create($restaurant_id, $name, $description, $price, $image_path) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO menu_items (restaurant_id, name, description, price, image_path)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$restaurant_id, $name, $description, $price, $image_path]);
        return $this->pdo->lastInsertId();
    }

    function update($id, $name, $description, $price, $image_path = null) {
        if ($image_path) {
            $stmt = $this->pdo->prepare(
                "UPDATE menu_items SET name=?, description=?, price=?, image_path=? WHERE id=?"
            );
            $stmt->execute([$name, $description, $price, $image_path, $id]);
        } else {
            $stmt = $this->pdo->prepare(
                "UPDATE menu_items SET name=?, description=?, price=? WHERE id=?"
            );
            $stmt->execute([$name, $description, $price, $id]);
        }
    }

    function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM menu_items WHERE id=?");
        $stmt->execute([$id]);
    }

    function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM menu_items WHERE id=? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function find_with_restaurant($id) {
        $sql = "SELECT m.*, r.name AS restaurant_name, r.location, r.area
                FROM menu_items m
                JOIN restaurants r ON r.id = m.restaurant_id
                WHERE m.id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function by_restaurant($restaurant_id) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM menu_items WHERE restaurant_id=? ORDER BY created_at DESC"
        );
        $stmt->execute([$restaurant_id]);
        return $stmt->fetchAll();
    }

    // ajax search on menu items
    function search($q = '') {
        if ($q === '') return [];
        $stmt = $this->pdo->prepare(
            "SELECT m.*, r.name AS restaurant_name
             FROM menu_items m
             JOIN restaurants r ON r.id = m.restaurant_id
             WHERE m.name LIKE ? OR m.description LIKE ?
             ORDER BY m.created_at DESC LIMIT 30"
        );
        $like = '%' . $q . '%';
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll();
    }

    function count_all() {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM menu_items")->fetchColumn();
    }
}
