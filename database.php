<?php
    require_once('connection.php');
    function get_music() {
        $conn = connect_to_db();
        $musics = [];
            $m = $conn->query("SELECT * from displaymusic LIMIT 24");
            for($i = 1; $i <= $m->num_rows; $i++) {
                $musics[] = $m->fetch_assoc();
            }
        return $musics;
    }
    function get_search_music($name) {
        $conn = connect_to_db();
        $keyword = '%' . $name .'%';
        $m = $conn->query("SELECT * from displaymusic Where name like '$keyword' OR actor like '$keyword'");

        $musics = [];
        for($i = 1; $i <= $m->num_rows; $i++) {
            $musics[] = $m->fetch_assoc();
        }

        return $musics;
    }

    function add_music($name, $file, $actor, $image, $album, $category)
    {
        if(is_song_exists($name)) {
            return array('code' => 1, 'error' => 'Bài Hát Đã Có Sẵn Trong List');
        }
            $conn = connect_to_db();
            $Maxid = 'SELECT MAX(id) as max_id FROM displaymusic';
            $stm = $conn->prepare($Maxid);
            if(!$stm->execute()) {
                return array('code' => 2, 'error' => 'Không thể thực thi câu lệnh');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            $maxid = $data['max_id'];
            $new_id = (int)$maxid + 1;

            $sql = "INSERT into displaymusic(id, name, file, actor, image, album, category) values(?,?,?,?,?,?,?)";
            
            $stm = $conn->prepare($sql);
            $stm->bind_param('issssss', $new_id, $name, $file, $actor, $image, $album, $category);
            if(!$stm->execute()) {
                return array('code' => 3, 'error' => 'Không thể thêm bài hát');
            }

            return array('code' => 0, 'success' => 'Thêm bài hát mới thành công');
    }

    function is_song_exists($songName) {
        $sql = 'SELECT name FROM displaymusic where name = ?';
        $conn = connect_to_db();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $songName);

        if(!$stm->execute()) {
            die('Query error: ' . $stm->error);
        }

        $result = $stm->get_result();
        if($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
        
    }
?>