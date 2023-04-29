<?php
// Thực hiện kết nối đến cơ sở dữ liệu
require_once('connection.php');
// Kiểm tra kết nối
$conn = connect_to_db();

// Lấy từ khóa tìm kiếm từ phía máy khách
$search_term = $_GET['keyword'];
if($search_term != '') {
    // Truy vấn cơ sở dữ liệu để lấy các bài hát gợi ý
    $sql = "SELECT * FROM displaymusic WHERE name LIKE '%$search_term%' or actor LIKE '%$search_term%' LIMIT 6";
    $result = mysqli_query($conn, $sql);

    // Tạo mảng chứa các bản ghi phù hợp
    $songs = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $song = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'file' => $row['file'],
                'actor' => $row['actor'],
                'image' => $row['image'],
                'album' => $row['album'],
                'category' => $row['category'],
                'lyric' => $row['lyric']
            );
            array_push($songs, $song);
        }
    }

    // Trả về kết quả dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($songs);
}
?>