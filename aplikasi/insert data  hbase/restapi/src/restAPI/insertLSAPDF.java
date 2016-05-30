package restAPI;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.hbase.HBaseConfiguration;
import org.apache.hadoop.hbase.client.HTable;
import org.apache.hadoop.hbase.client.Put;
import org.apache.hadoop.hbase.util.Bytes;

//ini primary key nya value?
public class insertLSAPDF {

	public static void main(String[] args) throws IOException {
		 
        BufferedReader br;
        String line;
        try {
            br=new BufferedReader(new FileReader("/home/riskaamalia/lsa_pdf.csv"));
            // Instantiating Configuration class
    	      Configuration config = HBaseConfiguration.create();

    	      // Instantiating HTable class
    	      HTable hTable = new HTable(config, "lsa_halaman_pdf");

    	      
            int i=0;
            while((line=br.readLine())!=null){
                
            
                String[] kolom=line.split(",");      	      
	      	    // Instantiating Put class
	      	      // accepts a row name.
                Put p = new Put(Bytes.toBytes("id"+i)); 
	              
	      	      // adding values using add() method
	      	      // accepts column family name, qualifier/row name ,value

	      		  p.add(Bytes.toBytes("lsa_halaman_pdf_info"),Bytes.toBytes("ID_URL_1"),
	      	      Bytes.toBytes(kolom[0]));
	      		  p.add(Bytes.toBytes("lsa_halaman_pdf_info"),Bytes.toBytes("ID_URL_2"),
	    	      Bytes.toBytes(kolom[1]));
	      		  p.add(Bytes.toBytes("lsa_halaman_pdf_info"),Bytes.toBytes("VALUE"),
	    	      Bytes.toBytes(kolom[2]));	      		  
	      	      // Saving the put Instance to the HTable.
	      	      hTable.put(p);
	      	      i++;
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
