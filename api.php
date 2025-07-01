<?php
require 'db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';
$id = $_GET['id'] ?? null;

// Ambil JSON payload dari body
function getBody() {
    return json_decode(file_get_contents("php://input"), true);
}

// --- CRUD: Tabel ALTERNATIF ---
if ($endpoint === 'alternatif') {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM alternatif ORDER BY id DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    elseif ($method === 'POST') {
        $data = getBody();
        $stmt = $pdo->prepare("INSERT INTO alternatif 
            (nama, npm, prodi, c1, c2, c3, c4, c5, c6, c7, c8) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['nama'], $data['npm'], $data['prodi'],
            $data['c1'], $data['c2'], $data['c3'], $data['c4'],
            $data['c5'], $data['c6'], $data['c7'], $data['c8']
        ]);
        echo json_encode(['status' => 'added', 'id' => $pdo->lastInsertId()]);
    }

    elseif ($method === 'PUT') {
        $data = getBody();
        $stmt = $pdo->prepare("UPDATE alternatif SET 
            nama=?, npm=?, prodi=?, 
            c1=?, c2=?, c3=?, c4=?, c5=?, c6=?, c7=?, c8=? 
            WHERE id=?");
        $stmt->execute([
            $data['nama'], $data['npm'], $data['prodi'],
            $data['c1'], $data['c2'], $data['c3'], $data['c4'],
            $data['c5'], $data['c6'], $data['c7'], $data['c8'],
            $data['id']
        ]);
        echo json_encode(['status' => 'updated']);
    }

    elseif ($method === 'DELETE' && $id) {
        $stmt = $pdo->prepare("DELETE FROM alternatif WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['status' => 'deleted']);
    }
}

// --- NORMALISASI (opsional, jika kamu menggunakannya) ---
elseif ($endpoint === 'normalisasi') {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM normalisasi ORDER BY id DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    elseif ($method === 'POST') {
        $data = getBody();
        $stmt = $pdo->prepare("INSERT INTO normalisasi 
            (nama, c1, c2, c3, c4, c5, c6, c7, c8) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['nama'],
            $data['c1'], $data['c2'], $data['c3'], $data['c4'],
            $data['c5'], $data['c6'], $data['c7'], $data['c8']
        ]);
        echo json_encode(['status' => 'added', 'id' => $pdo->lastInsertId()]);
    }

    elseif ($method === 'PUT') {
        $data = getBody();
        $stmt = $pdo->prepare("UPDATE normalisasi SET 
            nama=?, c1=?, c2=?, c3=?, c4=?, c5=?, c6=?, c7=?, c8=? 
            WHERE id=?");
        $stmt->execute([
            $data['nama'],
            $data['c1'], $data['c2'], $data['c3'], $data['c4'],
            $data['c5'], $data['c6'], $data['c7'], $data['c8'],
            $data['id']
        ]);
        echo json_encode(['status' => 'updated']);
    }

    elseif ($method === 'DELETE' && $id) {
        $stmt = $pdo->prepare("DELETE FROM normalisasi WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['status' => 'deleted']);
    }
}