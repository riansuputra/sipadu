<?php


class LogModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data)
    {
        if (empty($data['user_id']) || empty($data['action']) || empty($data['entity_type'])) {
            return;
        }

        $stmt = $this->db->prepare("
            INSERT INTO log
            (user_id, role_id, action, entity_type, entity_id, description, ip_address, user_agent)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            (int)$data['user_id'],
            $data['role_id'] ?? null,
            $data['action'],
            $data['entity_type'],
            $data['entity_id'] ?? null,
            $data['description'] ?? null,
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
    }
}
