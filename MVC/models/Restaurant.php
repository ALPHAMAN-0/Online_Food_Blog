<?php
// restaurants table model

class Restaurant {
    private $pdo;
    function __construct($pdo) { $this->pdo = $pdo; }

    function create($name, $location, $area, $bg, $goals) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO restaurants (name, location, area, short_background, goals)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$name, $location, $area, $bg, $goals]);
        return $this->pdo->lastInsertId();
    }

    function update($id, $name, $location, $area, $bg, $goals) {
        $stmt = $this->pdo->prepare(
            "UPDATE restaurants
             SET name=?, location=?, area=?, short_background=?, goals=?
             WHERE id=?"
        );
        $stmt->execute([$name, $location, $area, $bg, $goals, $id]);
    }

    function delete($id) {
        // cascade in schema kills menu_items
        $stmt = $this->pdo->prepare("DELETE FROM restaurants WHERE id=?");
        $stmt->execute([$id]);
    }

    function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM restaurants WHERE id=? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function all() {
        $stmt = $this->pdo->query("SELECT * FROM restaurants ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    // free-text search + optional filters. used by AJAX and normal list page.
    function search($q = '', $location = '', $area = '') {
        $sql = "SELECT * FROM restaurants WHERE 1=1";
        $params = [];
        if ($q !== '') {
            $sql .= " AND name LIKE ?";
            $params[] = '%' . $q . '%';
        }
        if ($location !== '') {
            $sql .= " AND location LIKE ?";
            $params[] = '%' . $location . '%';
        }
        if ($area !== '') {
            $sql .= " AND area LIKE ?";
            $params[] = '%' . $area . '%';
        }
        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    function count_all() {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM restaurants")->fetchColumn();
    }
}
