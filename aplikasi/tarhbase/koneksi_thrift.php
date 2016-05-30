<?php

//bagian koneksi ke thrift
$GLOBALS['THRIFT_ROOT'] = '/usr/local/thrift-0.9.2/lib/php/lib/Thrift';

require_once('/usr/local/thrift-0.9.2/lib/php/src/Thrift.php');

require_once($GLOBALS['THRIFT_ROOT'].'/Type/TMessageType.php');
require_once($GLOBALS['THRIFT_ROOT'].'/Type/TType.php');
require_once($GLOBALS['THRIFT_ROOT'].'/Exception/TException.php');
require_once($GLOBALS['THRIFT_ROOT'].'/Factory/TStringFuncFactory.php');
require_once($GLOBALS['THRIFT_ROOT'].'/StringFunc/TStringFunc.php');
require_once($GLOBALS['THRIFT_ROOT'].'/StringFunc/Core.php');
require_once($GLOBALS['THRIFT_ROOT'].'/Transport/TSocket.php');
require_once($GLOBALS['THRIFT_ROOT'].'/Transport/TBufferedTransport.php');
require_once($GLOBALS['THRIFT_ROOT'].'/Protocol/TBinaryProtocol.php');

require_once('hbase-thrift-php/thrift/lib/HBase/Hbase.php');
require_once('hbase-thrift-php/thrift/lib/HBase/Types.php');

use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;
use Thrift\Protocol\TBinaryProtocol;
use Hbase\HbaseClient;
use Hbase\Mutation;
use Hbase\TScan;

$socket = new TSocket('localhost', 9090);
$socket->setSendTimeout(10000); // Ten seconds (too long for production, but this is just a demo ;)
$socket->setRecvTimeout(20000); // Twenty seconds
$transport = new TBufferedTransport( $socket );
$protocol = new TBinaryProtocol( $transport );
$client = new HbaseClient( $protocol );
//sampai sini
?>