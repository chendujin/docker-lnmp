<?php
class KafkaProducer
{
    public static $brokerList = '10.44.4.17:9092';
    public static $topic = 'thomas_test_topic1';

    public static function send($message, $topic = '')
    {
        self::producer($message, $topic ?: self::$topic);
    }

    public static function producer($message, $topic = 'test')
    {
        $conf = new \RdKafka\Conf();

        $conf->set('metadata.broker.list', self::$brokerList);

        $producer = new \RdKafka\Producer($conf);

        $topic = $producer->newTopic($topic);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($message));

        $producer->poll(0);

        $result = $producer->flush(10000);

        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
            throw new \RuntimeException('Was unable to flush, messages might be lost!');
        }
        var_dump($result);
    }
}

class KafkaConsumer
{
    public static $brokerList = '10.44.4.17:9092';
    public static $topic = 'thomas_test_topic1';

    public static function consumer()
    {
        $conf = new \RdKafka\Conf();

        $conf->set('group.id', 'test');

        $rk = new \RdKafka\Consumer($conf);

        $rk->addBrokers(self::$brokerList);

        $topicConf = new \RdKafka\TopicConf();

        $topicConf->set('auto.commit.interval.ms', 100);

        $topicConf->set('offset.store.method', 'broker');

        $topicConf->set('auto.offset.reset', 'smallest');

        $topic = $rk->newTopic(self::$topic, $topicConf);

        $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);

        while (true) {
            $message = $topic->consume(0, 120*10000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    var_dump($message);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "Timed out\n";
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
                    break;
            }
        }
    }
}
try {
    $res = KafkaProducer::send(['action' => 'order_create', 'data' => ['order_id' => '123', 'type' => 1, 'create_at' => '2021-11-20 17:35:12']]);
    // KafkaConsumer::consumer();
} catch (\Throwable $th) {
    var_dump($th->getMessage());
}
