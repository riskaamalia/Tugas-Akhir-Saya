<?php



class hbase_stargate {

    var $host, $port;


    function __construct($host='127.0.0.1', $port=8080) {
        $this->host = $host;
        $this->port = $port;
    }



  /**
     * @name    Select one row
     * @example $obj->select('table', 'row', 'column1'));
     * @return array
    */
    public function select($table, $row, $column=null) {
        $column = !empty($column) ? '/'.$column : '';
        $obj = $this->write('GET', '/'.$table.'/'.$row.$column);

        if(!is_object($obj)) {
            return false;
        }

        $arr = array();
        foreach($obj->Row[0]->Cell as $k=>$r) {
            $keyName = preg_replace('#:$#','', base64_decode($obj->Row[0]->Cell[$k]->column));
            if(!array_key_exists($keyName, $arr)) {
                $arr[$keyName] = base64_decode($obj->Row[0]->Cell[$k]->{'$'});
            echo $arr[$keyName]."     ";
	 }
        }
        return $arr;
    }

    /**
     * @name    Write request
     * @access  private
     * @return  json_decode OR header
  */  
    private function write($method, $path, $content=null) {
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://'.$this->host.':'.$this->port.$path);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json',
			'Connection: Close',
		));

		switch(strtoupper($method)){
			case 'DELETE':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
			case 'PUT':
				curl_setopt($curl, CURLOPT_PUT, 1);
				$file = tmpfile();
				fwrite($file, $content);
				fseek($file, 0);
				curl_setopt($curl, CURLOPT_INFILE, $file);
				curl_setopt($curl, CURLOPT_INFILESIZE, strlen($content));
				break;
			case 'POST':
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
				break;
			case 'GET':
				curl_setopt($curl, CURLOPT_HTTPGET, 1);
				break;
		}

		$data = curl_exec($curl);
        curl_close($curl);
        $buff = $data;

        return ereg('{', $buff) ? json_decode(preg_replace('#^.*?\{#s', '{', $buff)) : $buff;
    }


    /**
     * @name    Table List
     * @example $obj->list_table());
     * @return  orray
*/    
    public function list_table() {
        $obj = $this->write('GET', '/');

        $arr = array();
        foreach($obj->table as $k=>$r) {
            if(!in_array($r->name, $arr)) {
                array_push($arr, $r->name);
            }
        }
        return $arr;
    }


    /**
     * @name    Table Schema
     * @example $obj->table_schema('table'));
     * @return  object
    */
    public function table_schema($table) {
        $obj = $this->write('GET', '/'.$table.'/schema');
        return $obj;
    }
  


    /**
     * @name    Insert
     * @example $obj->insert('table', 'row', array('column1' => 'value1'));
     * @return  boolean
*/    
    public function post($table, $row, $data) {
        $cell = array();
        foreach($data as $k=>$r) {
            array_push($cell, array('column'=>base64_encode($k), '$'=>base64_encode($r)));
        }
        $json = '{"Row":[{"Cell":'.json_encode($cell).'}]}';

        $str = $this->write('POST', '/'.$table.'/'.$row, $json);

        return ereg('HTTP/1.1 200', $str) ? true : false;
    }


    /**
     * @name    Remove
     * @example $obj->remove('table', 'row');
     * @example $obj->remove('table', 'row', 'column');
     * @example $obj->remove('table', 'row', array('column1', 'column2'));
     * @return  boolean
  */  
    public function remove($table, $row, $data=null) {
        if($data) {
            if(is_array($data)) {
                foreach($data as $k=>$r) {
                    $str = $this->write('DELETE', '/'.$table.'/'.$row.'/'.$r);
                    if(!ereg('HTTP/1.1 200', $str)) {
                        return 'error';
                    }
                }
            }
            else {
                $str = $this->write('DELETE', '/'.$table.'/'.$row.'/'.$data);
            }
        }
        else {
            $str = $this->write('DELETE', '/'.$table.'/'.$row);
        }
        return ereg('HTTP/1.1 200', $str) ? true : false;
    }

 }



$contoh = new  hbase_stargate ();
$contoh -> select("url", "1","");

?>