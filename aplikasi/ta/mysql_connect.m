clc
dbname = 'maintenance';
username = 'root';
password = '';
driver = 'com.mysql.jdbc.Driver';
javaclasspath('C:\xampp\htdocs\taR\mysql-connector-java-5.1.23-bin.jar');
dburl = ['jdbc:mysql://localhost:3306/' dbname];
conn = database(dbname, username, password, driver, dburl);
curs = exec(conn, 'select DB_aktif from maintenance');
curs = fetch(curs);
if(strcmp(curs.Data{1},'ta'))
    dbname = 'ta2';
else
    dbname = 'ta';
end
dburl = ['jdbc:mysql://localhost:3306/' dbname];
conn = database(dbname, username, password, driver, dburl);