<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['user']) ? $_POST['user'] : '';
    $password = isset($_POST['pass']) ? $_POST['pass'] : '';

    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'fail', 'message' => 'Vui lòng điền đầy đủ thông tin đăng nhập.']);
        exit;
    }

    $result = login($username, $password);

    echo $result;
}

function login($user, $pass){
    $sql = "select * from account where username = ?";
    $conn = connect_to_db();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    if (!$stm->execute()){
        return json_encode(['status' => 'fail', 'message' => 'Error from server.']);
    }
    $result = $stm->get_result();

    if ($result->num_rows == 0){
        return json_encode(['status' => 'fail', 'message' => 'Username or password is not correct.']);
    }

    $data = $result->fetch_assoc();

    $hashed_password = $data['password'];
    if (!password_verify($pass,$hashed_password))
        return json_encode(['status' => 'fail', 'message' => 'Username or password is not correct.']);
        else if ($data['activated'] == 0)
        {
            return json_encode(['status' => 'fail', 'message' => 'This account is not activated!']);
        }else {
            return json_encode(['status' => 'success', 'message' => 'Login successfully.']);
    }
}
