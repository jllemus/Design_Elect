## Conexión con la base de datos

import mysql.connector

con = mysql.connector.connect(host='localhost', user='root', password='',database="bd")

cursor = con.cursor()

cursor.execute("CREATE TABLE vehicle_info (latitud FLOAT, longitud FLOAT, fecha_hora VARCHAR(100));")

con.close

