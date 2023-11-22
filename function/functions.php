<?php
//koneksi ke database
$server = "localhost:3310";
$user = "root";
$password = "";
$nama_db = "dms";
$koneksi = mysqli_connect($server,$user,$password,$nama_db);

//function koneksi
function  query($query){
    global $koneksi;
    $result = mysqli_query($koneksi,$query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)){
        $rows[]= $row;
    }
    return $rows
}

//function registrasi
function registrasi($data){
    global $koneksi;
    $username = strtolower(stripcslashes($data["username"]));
    $email = htmlspecialchars_decode($data["email"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data)["password2"];

    //cek username sudah terdaftar apa belum
    $result = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = 'username'");
    if (mysqli_fetch_assoc($result)){
        echo "
        <script>
        alert('maaf, username sudah terdaftar!') 
        </script>";
    return false;
    }

    //cek konfirmasi password 
    if($password !== $password2){
        echo"
        <script>
            alert('maaf, konfirmasi password tidak sesuai!')
        </script>";
        return false;
    }

    //ekripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //menambahkan user baru ke dalam db
    mysqli_query($koneksi, "INSERT INTO tbl_user VALUES ('', '$username, '$email', '$password')"); 
    return mysqli_affected_rows($koneksi);

}

?>
