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

public class insertDataTerm {

	public static void main(String[] args) throws IOException {
 
        BufferedReader br;
        String line;
        try {
            br=new BufferedReader(new FileReader("/home/riskaamalia/term.csv"));
            // Instantiating Configuration class
    	      Configuration config = HBaseConfiguration.create();

    	      // Instantiating HTable class
    	      HTable hTable = new HTable(config, "term");


            
            while((line=br.readLine())!=null){
                
            
                String[] kolom=line.split(",");      	      
	      	    // Instantiating Put class
	      	      // accepts a row name.
	      	      Put p = new Put(Bytes.toBytes(kolom[0])); 
	              
	      	      // adding values using add() method
	      	      // accepts column family name, qualifier/row name ,value

	      		  p.add(Bytes.toBytes("term_info"),Bytes.toBytes("TERM"),
	      	      Bytes.toBytes(kolom[1]));
	      		  p.add(Bytes.toBytes("term_info"),Bytes.toBytes("PREFIX_TERM"),
	      		  Bytes.toBytes(kolom[2]));
	      		  
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