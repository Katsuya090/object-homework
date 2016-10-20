<?php

// DB接続に必要な情報
// define('DSN','mysql:host=localhost;dbname=member1;charset=utf8');
// define('USER','root');
// define('PASSWORD','root');



// // データ取得

// $dbh = connectDatabase();
// $sql = "select * from members where id = :id";
// $stmt = $dbh->prepare($sql);
// $stmt->bindParam(":id", $id);
// $stmt->execute();

// $row = $stmt->fetch();

// $dbh = connectDatabase();
// $sql = "select * from members where name = :name";
// $stmt = $dbh->prepare($sql);
// $stmt->bindParam(":name", $name);
// $stmt->execute();

// $row = $stmt->fetch();

// $dbh = connectDatabase();
// $sql = "select * from members where email = :email";
// $stmt = $dbh->prepare($sql);
// $stmt->bindParam(":email", $email);
// $stmt->execute();

// $row = $stmt->fetch();


// $dbh = connectDatabase();
// $sql = "select * from members where created_at = :created_at";
// $stmt = $dbh->prepare($sql);
// $stmt->bindParam(":created_at", $created_at);
// $stmt->execute();

// $row = $stmt->fetch();

// 削除








class Member{
  public $data;


  public $dbh;

  // const DB_NAME='db_name';
  // const HOST='localhost';
  // const UTF='utf8';
  // const USER='root';
  // const PASS='root';
  //データベースに接続する関数
  function pdo(){
    /*phpのバージョンが5.3.6よりも古い場合はcharset=".self::UTFが必要無くなり、array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF')が必要になり、5.3.6以上の場合は必要ないがcharset=".self::UTFは必要になる。*/
    $dsn="mysql:host=localhost;dbname=member1;charset=utf8";
    $user="root";
    $pass="root";
    try{
      $dbh = new PDO($dsn,$user,$pass);

    }catch(Exception $e){
      echo 'error' .$e->getMesseage;
      die();
    }
    //エラーを表示してくれる。
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    return $dbh;
  }
  public function set($data)
  {
    // var_dump($data);
    $this->data =$data;

  }
  public function insert()
  {
    $dbh = $this->pdo();
    // try
    // {
    //   $dbh= new PDO(DSN,USER,PASSWORD);
    // }
    // catch (PDOException $e)
    // {
    //   echo $e->getMessage();
    //   exit;
    // }

    // var_dump($this->data);
  // 登録
      $sql = "insert into members (name, age, email, created_at) values
                (:name, :age, :email, now())";

      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(":name", $this->data['name']);
      $stmt->bindParam(":age", $this->data['age']);
      $stmt->bindParam(":email", $this->data['email']);
      $stmt->execute();
  }
  public function findByEmail($data)
  {
    $dbh = $this->pdo();
    // var_dump($data);
    // try
    // {
    //   $dbh= new PDO(DSN,USER,PASSWORD);
    // }
    // catch (PDOException $e)
    // {
    //   echo $e->getMessage();
    //   exit;
    // }
    $sql = "select * from members where email = :email";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":email", $data);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($posts);
    if (!$row)
    {
      echo 'false';
      exit;
    }
    return $row;
  }
  public function delete($data)
  {
    $dbh = $this->pdo();
    // try
    // {
    //   $dbh= new PDO(DSN,USER,PASSWORD);
    // }
    // catch (PDOException $e)
    // {
    //   echo $e->getMessage();
    //   exit;
    // }
    $sql_delete = "delete from members where id = :id";
    $stmt_delete = $dbh->prepare($sql_delete);
    $stmt_delete->bindParam(":id", $data);
    $stmt_delete->execute();

  }
}



// members テーブルのデータを表します。
$member = new Member();
// メンバーのデータをセットします。
$member->set(array(
  'name' => 'テスト名',
  'age' => 30,
  'email' => 'test@example.com',
));
$pdo = $member->pdo();

// $member->set() でセットしたデータを members テーブルに追加登録します。
// この時 created_at カラムに現在日時を自動的にセットするようにしてください。
// 登録が成功した場合は true 、失敗した場合は false を返します。
$result = $member->insert();

// 引数で指定されたメールアドレスのユーザーを members テーブルから探し、
// もし見つかった場合、そのデータを以下の形式で返します。
// array(
//   'id' => 'members テーブル の id カラムの値',
//   'name' => 'members テーブル の name カラムの値',
//   'age' => 'members テーブル の age カラムの値',
//   'email' => 'members テーブル の email カラムの値',
//   'created_at' => 'members テーブル の created_at カラムの値',
// );
// ユーザーが見つからなかった場合、false を返します。
$data = $member->findByEmail('test@example.com');
var_dump($data);

// 引数で指定された id を持つ members テーブルのレコードを削除します。
// 削除が成功した場合は true 、失敗した場合は false を返します。
$result = $member->delete($data['id']);

// ここでは false が返ってくるはずです。
$data = $member->findByEmail('test@example.com');
var_dump($data);
exit;


?>