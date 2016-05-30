<?php

include "koneksi_thrift.php";

try {
    $transport->open();
    //$url = $obj_url -> select("url",$hasil[$a],"url_info:URL");
    $table = 'url';
    $rowkey = '90';
    $column = 'url_info:URL';

    $values = ($client->get($table, $rowkey, $column, null));

    foreach ($values as $k=>$v) {
        //print_r ("  {$k} => {$v->value} \n");
        $hasil = $v ->value;
        echo $hasil; 
    }

    $transport->close();

} catch (TException $e) {
    print 'TException: '.$e->__toString().' Error: '.$e->getMessage()."\n";
}
