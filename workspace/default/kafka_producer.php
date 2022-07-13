<?php
// $conf = new RdKafka\Conf();
// $conf->setErrorCb(function($kafka, $err, $reason){
//     var_dump($err);
//     var_dump($reason);
// });
// $conf->setDrMsgCb(function($kafka, $message){
//     if($message->err) var_dump("发送失败：");
//     else var_dump("发送成功：");
//     var_dump($message);
// });

// $rk = new RdKafka\Producer($conf);
// $rk->addBrokers("10.44.4.17:9092");

// $topicConf = new RdKafka\TopicConf();
// $topicConf->set("message.timeout.ms", 3000);

// $topic = $rk->newTopic("thomas_test_topic", $topicConf);
// $topic->produce(RD_KAFKA_PARTITION_UA, 0, "老哥说：现在". date("H:i:s"). "了");

// class KafkaProducer
// {
//     public static $brokerList = '10.44.4.17:9092';
//     public static $topic = 'thomas_test_topic';

//     public static function send($message, $topic = '')
//     {
//         self::producer($message, $topic ?: self::$topic);
//     }

//     public static function producer($message, $topic = 'thomas_test_topic')
//     {
//         $conf = new \RdKafka\Conf();

//         $conf->set('metadata.broker.list', self::$brokerList);

//         $producer = new \RdKafka\Producer($conf);

//         $topic = $producer->newTopic($topic);

//         $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($message));

//         $producer->poll(0);

//         $result = $producer->flush(10000);

//         if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
//             throw new \RuntimeException('Was unable to flush, messages might be lost!');
//         }
//         var_dump($result);
//     }
// }

// try {
//     $res = KafkaProducer::send(['action' => 'order_create', 'data' => ['order_id' => '123', 'type' => 1, 'create_at' => '2021-11-20 17:35:12']]);
//     // KafkaConsumer::consumer();
// } catch (\Throwable $th) {
//     var_dump($th->getMessage());
// }

$rk = new RdKafka\Producer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers("10.44.4.17:9092");       
$topic = $rk->newTopic("test");
$topic->produce(RD_KAFKA_PARTITION_UA, 0, "要发送的消息");