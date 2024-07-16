<?php
require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;


class Chat implements MessageComponentInterface {
    protected $clients;
    protected $imgData;
    protected $img_data;

    //コンストラクタ
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        // サーバーの起動時に過去の会話データを取得し、全てのクライアントに送信する
        // $this->sendPastConversationToAllClients();
        $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "SELECT imageID, image_data FROM images";
        $stmt = $db->query($sql);
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $this->img_data = array();
    
        foreach ($images as $row) {
            $this->img_data[$row['imageID']] = base64_encode($row['image_data']);
        }
    }

    public function onOpen(ConnectionInterface $conn) {//コネクション待機
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";   
        $this->sendPastConversationToClient($conn);
        // $conn->send(json_encode($this->imgData));
    }


    protected function sendPastConversationToClient(ConnectionInterface $conn) {
        // 過去の会話データを取得(全てのデータ)
        $pastConversation = $this->getPastConversationFromDatabase();
        
        // 過去の会話データ（１けんずつ）をクライアントに送信
        foreach ($pastConversation as $oldmessage) {
           // $oldsets = $oldmessage['userID'] .':'.$oldmessage['name'].'('.$oldmessage['date'].')'.$oldmessage['message'];

            // $conn->send(json_encode($oldmessage));

            // $conn->send(json_encode(['messages'=>$oldmessage]));


            // $conn->send(json_encode([
            //     // 'icon' => 'a',//$this->iconData($oldmessage['userID'])
            //     'messages' => $oldmessage
            // ]));
            $icon = $this->iconData($oldmessage['userID']);


            $conn->send(json_encode([
                'messages' => [$oldmessage], // $oldmessage を配列に入れる
                'icon' => $icon
            ]));
        }
    }


    //該当するユーザーIDのアイコン画像を返す。なければデフォルトのを返す
    public function iconData($userID) {

        // return base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/var/www/html/画像/icon.png'));


        // return $this->img_data[$userID];


        if (!empty($this->img_data[$userID])) {
            return $this->img_data[$userID];
         } else {
            // デフォルトのアイコンパスを返す
            // return '画像\icon.png';
            return base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/var/www/html/画像/icon.png'));
        }
    }

    
    //メッセージを受け取るメソッド
    public function onMessage(ConnectionInterface $from, $msg) {

        // 受信したメッセージをJSONからデコード
        $messageData = json_decode($msg, true);

        //$setms = $messageData['userID'] .':'.$messageData['name'].'('.$messageData['date'].')'.$messageData['message'];

        // メッセージデータの内容をファイルに出力する
        file_put_contents('message_log.txt', print_r($messageData, true) . PHP_EOL, FILE_APPEND);

        // メッセージをデータベースに格納する
        $this->saveMessageToDatabase($messageData);

        // $messageWithId = array(
        //     'id' => uniqid(), // 一意のIDを生成
        //     'message' => $setms
        // );

        $icon = $this->iconData($messageData['userID']);

        
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send(json_encode([
                    'messages' => [$messageData], // $oldmessage を配列に入れる
                    'icon' => $icon
                ]));
            }
        }

    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    // メッセージをデータベースに格納する関数
    public function saveMessageToDatabase($messageData) {
        try {
            // データベースへの接続を確立（$dbにPDOオブジェクトが格納されていると仮定）
              $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");



            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // メッセージを挿入するSQLクエリを準備
            $sql = 'INSERT INTO chat_tb (userID, name, message, date, currentID) VALUES (:userID, :name, :message, :date, :currentID)';
            $stmt = $db->prepare($sql);

           // echo $messageData['userID'];

            // パラメータをバインドしてクエリを実行
            $stmt->bindParam(':userID', $messageData['userID']);
            $stmt->bindParam(':name', $messageData['name']);
            $stmt->bindParam(':message', $messageData['message']);
            $stmt->bindParam(':date', $messageData['date']);
            $stmt->bindParam(':currentID', $messageData['currentID']);
            $stmt->execute();

        } catch (PDOException $e) {
            // エラー処理
            echo "Error: " . $e->getMessage();
        }
    }

    //過去の会話データとる
    public function getPastConversationFromDatabase() {
        try {
            // データベースへの接続を確立（$dbにPDOオブジェクトが格納されていると仮定）
              $db = new PDO("mysql:dbname=shift_db;host=localhost;charset=utf8mb4", "root", "");



            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // メッセージを挿入するSQLクエリを準備
            $sql = $db->query('SELECT userID, name, message, date FROM chat_tb ORDER BY date ASC');
            $resister = $sql->fetchAll(PDO::FETCH_ASSOC);

            $conversationData = array();

            // 取得したデータを配列に格納
            foreach($resister as $result){
                $resultData = array(
                    'userID' => $result['userID'],
                    'name' => $result['name'],
                    'message' => $result['message'],
                    'date' => $result['date']
                );
                $conversationData[] = $resultData;
            }


            print_r($conversationData);

            return $conversationData;


        } catch (PDOException $e) {
            // エラー処理
            echo "Error: " . $e->getMessage();
        }


    }


}
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

echo "WebSocket server started.\n";

$server->run();//Webサーバーを起動！


?>
