package restAPI;

import java.io.IOException;
import org.apache.hadoop.hbase.HBaseConfiguration;
import org.apache.hadoop.hbase.HColumnDescriptor;
import org.apache.hadoop.hbase.HTableDescriptor;
import org.apache.hadoop.hbase.client.HBaseAdmin;
import org.apache.hadoop.hbase.TableName;

import org.apache.hadoop.conf.Configuration;

public class CreateTable {
      
   public static void main(String[] args) throws IOException {

      // Instantiating configuration class
      Configuration con = HBaseConfiguration.create();
      //create 'url','url_info','pdf','halaman_web','url_pembobotan_web','url_pembobotan_pdf'

      // Instantiating HbaseAdmin class
      HBaseAdmin admin = new HBaseAdmin(con);

      // Instantiating table descriptor class untuk tabel url
      HTableDescriptor tableDescriptor = new
      HTableDescriptor(TableName.valueOf("url"));

      // Adding column families to table descriptor
      tableDescriptor.addFamily(new HColumnDescriptor("url_info"));
      tableDescriptor.addFamily(new HColumnDescriptor("pdf"));
      tableDescriptor.addFamily(new HColumnDescriptor("halaman_web"));
      tableDescriptor.addFamily(new HColumnDescriptor("url_pembobotan_web"));
      tableDescriptor.addFamily(new HColumnDescriptor("url_pembobotan_pdf"));
      
      //create 'term','term_info','term_pembobotan_web','term_pembobotan_pdf'
      HTableDescriptor tableDescriptor2 = new
      HTableDescriptor(TableName.valueOf("term"));

      // Adding column families to table descriptor
      tableDescriptor2.addFamily(new HColumnDescriptor("term_info"));
      tableDescriptor2.addFamily(new HColumnDescriptor("term_pembobotan_web"));
      tableDescriptor2.addFamily(new HColumnDescriptor("term_pembobotan_pdf"));      

      //create 'lsa_halaman_web','lsa_halaman_web_info'
      //HTableDescriptor tableDescriptor3 = new
      //HTableDescriptor(TableName.valueOf("lsa_halaman_web"));

      // Adding column families to table descriptor
      //tableDescriptor3.addFamily(new HColumnDescriptor("lsa_halaman_web_info"));
      
      //create 'lsa_halaman_pdf','lsa_halaman_pdf_info'
      //HTableDescriptor tableDescriptor4 = new
      //HTableDescriptor(TableName.valueOf("lsa_halaman_pdf"));

      // Adding column families to table descriptor
      //tableDescriptor4.addFamily(new HColumnDescriptor("lsa_halaman_pdf_info"));

      // Execute the table through admin
      admin.createTable(tableDescriptor);
      admin.createTable(tableDescriptor2);
      //admin.createTable(tableDescriptor3);
      //admin.createTable(tableDescriptor4);
      System.out.println(" Table created ");
   }
}