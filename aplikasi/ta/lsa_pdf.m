clear;
clc;
mysql_connect;
curs = exec(conn, 'select id_url,id_term,frekuensi from pembobotan_pdf');
curs = fetch(curs);
TF = curs.Data;

curs = exec(conn, 'select count(distinct id_term) from pembobotan_pdf');
curs = fetch(curs);
rowSize = curs.Data{1};

curs = exec(conn, 'select count(distinct id_url) from pembobotan_pdf');
curs = fetch(curs);
columnSize = curs.Data{1};

curs = exec(conn, 'select count(*) from pembobotan_pdf');
curs = fetch(curs);
Size = curs.Data{1};

if(Size ~= 0)
close(conn);
close(curs);
clear curs;
clear conn;
clear dbname;
clear dburl;
clear driver;
clear password;
clear username;

for a = 1 : Size
    TF2(TF{a,2}+1,TF{a,1}+1) = TF{a,3};
end
b = size(TF2,2);
a = 1;
while(a <= b)
    if(sum(TF2(:,a)) == 0)
        TF2(:,a) = [];
        b = b - 1;
        a = a - 1;
    end
    a =  a + 1;
end
b = size(TF2,1);
a = 1;
while(a <= b)
    if(sum(TF2(a,:)) == 0)
        TF2(a,:) = [];
        b = b - 1;
        a = a - 1;
    end
    a =  a + 1;
end

clear a;
clear b;
clear TF;
clear Size;

[U,S,V] = svd(TF2,0);
clear TF2;
VT = transpose(V);
clear V;

SVD = U * S * VT;
clear U;
clear S;
clear VT;

for a = 1 : columnSize
    for b = 1 : columnSize
        if(a == b)
            LSA(a,b) = 1;
        else
            v1 = 0;
            v2 = 0;
            v3 = 0;
            for c = 1 : rowSize
                v1 = v1 + SVD(c,a) * SVD(c,b);
                v2 = v2 + SVD(c,a) * SVD(c,a);
                v3 = v3 + SVD(c,b) * SVD(c,b);
            end
            v2 = sqrt(v2);
            v3 = sqrt(v3);
            LSA(a,b) = v1/(v2 * v3);
        end
    end
end

clear a;
clear b;
clear SVD;
clear v1;
clear v2;
clear v3;

mysql_connect;

curs = exec(conn, 'select distinct id_url from pembobotan_pdf');
curs = fetch(curs);
pdf = curs.Data;

for a = 1 : columnSize
    for b = 1 : columnSize
        c = strcat('insert into lsa_pdf values (', num2str(pdf{a}), ',' , num2str(pdf{b}), ',' , num2str(abs(LSA(a, b))), ')');
        exec(conn, c);
    end
end

end
clear
lsa_web