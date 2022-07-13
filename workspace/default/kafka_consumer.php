<?php
// $groupID = "highLevel";
// $topicName = "thomas_test_topic";

// $conf = new RdKafka\Conf();
// $conf->setErrorCb(function($kafka, $err, $reason){
//     var_dump($err);
//     var_dump($reason);
// });
// $conf->setRebalanceCb(function (RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) {
//     switch ($err) {
//         case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
//             foreach($partitions as $partition){
//                 var_dump("指定分区：". $partition->getPartition());
//             }
//             $kafka->assign($partitions);
//             break;

//         case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
//             foreach($partitions as $partition){
//                 var_dump("删除分区：". $partition->getPartition());
//             }
//             $kafka->assign(NULL);
//             break;

//         default:
//             throw new \Exception($err);
//     }
// });
// $conf->set('group.id', $groupID);
// $conf->set('metadata.broker.list', "10.44.4.17:9092");

// $topicConf = new RdKafka\TopicConf();
// $topicConf->set('offset.store.method', 'file');
// $topicConf->set('offset.store.path', __DIR__);
// $topicConf->set('auto.commit.enable', 1);
// $topicConf->set('auto.commit.interval.ms', 10);
// $topicConf->set('auto.offset.reset', 'smallest');

// $conf->setDefaultTopicConf($topicConf);

// $consumer = new RdKafka\KafkaConsumer($conf);
// $consumer->subscribe(array($topicName));

// var_dump("启动中...");
// while (1) {
//     // try consumer record
//     $message = $consumer->consume(120*1000);
//     switch ($message->err) {
//         case RD_KAFKA_RESP_ERR_NO_ERROR:
//             var_dump($message->payload);
//             break;
//         case RD_KAFKA_RESP_ERR__PARTITION_EOF:
//             var_dump("没有更多消息了");
//             break;
//         case RD_KAFKA_RESP_ERR__TIMED_OUT:
//             var_dump("太长时间未收到消息了");
//             break;
//         default:
//             throw new Exception($message->errstr(), $message->err);
//             break;
//     }
// }

$rk = new RdKafka\Consumer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers("10.44.4.17:9092");
$topic = $rk->newTopic("test");
$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);
while(true){
    sleep(1);
    $msg = $topic->consume(0, 1000);
    if ($msg) {
        echo $msg->payload, "\n";
    }          
} 