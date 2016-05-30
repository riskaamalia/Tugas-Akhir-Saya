package restAPI;

import java.io.IOException;
import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.hbase.HBaseConfiguration;
import org.apache.hadoop.hbase.client.HTable;
import org.apache.hadoop.hbase.client.Put;
import org.apache.hadoop.hbase.util.Bytes;

public class InsertDataURL{

	public static void main(String[] args) throws IOException {
 
        BufferedReader br;
        String line;
        try {
            br=new BufferedReader(new FileReader("/home/riskaamalia/url.csv"));
            // Instantiating Configuration class
    	      Configuration config = HBaseConfiguration.create();

    	      // Instantiating HTable class
    	      HTable hTable = new HTable(config, "url");


            
            while((line=br.readLine())!=null){
                
            
                String[] kolom=line.split(",");      	      
	      	    // Instantiating Put class
	      	      // accepts a row name.
	      	      Put p = new Put(Bytes.toBytes(kolom[0])); 
	              
	      	      // adding values using add() method
	      	      // accepts column family name, qualifier/row name ,value

	      		  p.add(Bytes.toBytes("url_info"),Bytes.toBytes("URL"),
	      	      Bytes.toBytes(kolom[1]));
	      		  p.add(Bytes.toBytes("url_info"),Bytes.toBytes("DOMAIN"),
	      		  Bytes.toBytes(kolom[2]));
	      		  p.add(Bytes.toBytes("url_info"),Bytes.toBytes("STATUS_KUNJUNGAN"),
	  	      	  Bytes.toBytes(kolom[3]));
	  	      	  p.add(Bytes.toBytes("url_info"),Bytes.toBytes("LAST_MAINTENANCE"),
	  	      	  Bytes.toBytes(kolom[4]));
	  	      	  p.add(Bytes.toBytes("url_info"),Bytes.toBytes("STATUS_EKSTRAKSI"),
	  	  	      Bytes.toBytes(kolom[5]));
	      	      
	      	      
	      	      // Saving the put Instance to the HTable.
	      	      hTable.put(p);
	      	      System.out.println("data inserted");   
            }
              // closing HTable
    	      hTable.close();
        } catch (FileNotFoundException ex) {
            ex.printStackTrace();
        } catch (IOException ex) {
            ex.printStackTrace();
        }
    
   }
}
