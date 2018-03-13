## SNIFFER
import socket
import time
import mysql.connector

sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
host = socket.gethostbyname(socket.gethostname())
port = 1026
## Enlace del socket con el puerto.
server_add = (host, port)
print('Inicializando en Host IPV4 %s Puerto %s' % server_add)
sock.bind(server_add)

def main():
    while True: ##Ciclo para que solo muestre el conectado una vez
        print("Conectado")
        while True: ## Ciclo principal (Recepción de información)
                raw_data, addr = sock.recvfrom(2048) 
                save_data1 = str(raw_data)[2:]
                
                if raw_data:
                        print('Dirección' + str(addr))
                        conf,latitud,longitud,date = DecMsj(save_data1)
                        if conf:
                            print('La latitud es: ' + str(latitud) + ' y la longitud es: ' + str(longitud))
                            print('Fecha y hora: ' + date)
                            con = mysql.connector.connect(host='localhost', user='root', password='',database="bd")
                            cursor = con.cursor()         
                            #cursor.execute("INSERT INTO vehicle_info (latitud,longitud,fecha_hora) VALUES (%s,%s,%s)",(latitud,longitud,date))
                        
                            cursor.execute("UPDATE vehicle_info SET latitud=%s,longitud=%s,fecha_hora=%s" ,(latitud,longitud,date))    
                            con.commit()
                            con.close()

                                    
                                    
def DecMsj(Data):
    ## Confirmación de que sea el mensaje REV el decodificado
    if Data[0:4] == ">REV":
        conf = True
        ## Decodificación de la latitud y longitud
        latitud = float(Data[17:24]) / 100000
        longitud = float(Data[25:28]) + (float(Data[28:33]) /100000) 
        if Data[16] ==  "-":
            latitud = -latitud
        if Data[24] == "-":
            longitud = -longitud
        
        ## Decodificación de la fecha
            #num_days = int(Data[7:10])* 7 + 4
            #years = num_days/365
            #months = (num_days - (years*365))/30
            #days = num_days -(years*365)-(months*30)
            #date = decDate(Data[7:10],Data[11],Data[11:15])
        date = decDate(Data[6:10], Data[10], Data[11:16])
        ## Decodificación de la hora
        #x = int(Data[12:16])/3600
        #b = str(x).split(".")
        #Horas = int(b[0])
        #decimal = int(b[1])
        #minutos = decimal*60
        #minutos = str(minutos)
        #minutos1 = minutos[:2]
        #segundos = int(minutos[2:])*60
    else:  
        conf=False
        latitud = 0
        longitud = 0
        date = ' '   
    return conf,latitud,longitud,date


def decDate(week,day,hour):
    sec = int(week) * 7 * 24 * 60 * 60 + (int(day) + 3657) * 24 * 60 * 60 + int(hour)-0 * 60 * 60 
    # https://docs.python.org/2/library/time.html
    date = time.strftime("%b %d %Y %H:%M:%S", time.localtime(sec))
    return date


    
main()
