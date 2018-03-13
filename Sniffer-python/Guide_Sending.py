import mysql.connector

latitud = 11.0186636
longitud = -74.8518486
date = 10
## uniatlantico
#latitud = 11.0199225
#longitud = -74.8738197

##uninorte

#latitud = 11.0186636
#longitud = -74.8518486
con = mysql.connector.connect(host='localhost', user='root', password='',database="bd")
cursor = con.cursor()
cursor.execute("UPDATE vehicle_info SET latitud=%s,longitud=%s,fecha_hora=%s" ,(latitud,longitud,date))

        
con.commit()
con.close()

