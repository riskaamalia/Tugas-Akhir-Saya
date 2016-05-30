package APIbiasa;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
 
public class App {
    public static void main( String[] args ){
        
        BufferedReader br;
        String line;
        try {
            br=new BufferedReader(new FileReader("/home/riskaamalia/tabel_migrasi.csv"));
            while((line=br.readLine())!=null){
                
                String[] kolom=line.split(",");
                System.out.print("Kolom 1 :"+kolom[0]+" Kolom 2 :"+kolom[1]+" Kolom 3 :"+kolom[2]+" Kolom 4 :"+kolom[3]+ "\n");
                
            }
        } catch (FileNotFoundException ex) {
            ex.printStackTrace();
        } catch (IOException ex) {
            ex.printStackTrace();
        }
        
    }
}
