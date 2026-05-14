<?php
// users table model

class User {
    private $pdo;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function register($name, $email, $password, $role = 'member') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$name, $email, $hash, $role]);
        return $this->pdo->lastInsertId();
    }

    function find_by_email($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    function find_by_id($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function update_profile($id, $name, $email, $picture_path = null) {
        if ($picture_path) {
            $stmt = $this->pdo->prepare(
                "UPDATE users SET name=?, email=?, profile_picture=? WHERE id=?"
            );
            $stmt->execute([$name, $email, $picture_path, $id]);
        } else {
            $stmt = $this->pdo->prepare(
                "UPDATE users SET name=?, email=? WHERE id=?"
            );
            $stmt->execute([$name, $email, $id]);
        }
    }

    function change_password($id, $new_password) {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash=? WHERE id=?");
        $stmt->execute([$hash, $id]);
    }

    function set_remember_token($id, $token) {
        // store hashed token
        $hashed = hash('sha256', $token);
        $stmt = $this->pdo->prepare("UPDATE users SET remember_token=? WHERE id=?");
        $stmt->execute([$hashed, $id]);
    }

    function clear_remember_token($id) {
        $stmt = $this->pdo->prepare("UPDATE users SET remember_token=NULL WHERE id=?");
        $stmt->execute([$id]);
    }

    function list_members() {
        $stmt = $this->pdo->query(
            "SELECT id, name, email, profile_picture, created_at
             FROM users WHERE role='member' ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    function delete_user($id) {
        // FK cascade in schema removes their reviews/posts/comments
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id=? AND role='member'");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
