<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
<?php
	// Ejemplo de conexión a base de datos MySQL con PHP.
						//
						// Ejemplo realizado por Oscar Abad Folgueira: http://www.oscarabadfolgueira.com y https://www.dinapyme.com
						
						// Datos de la base de datos
						$usuario = "root";
						$password = "";
						$servidor = "localhost";
						$basededatos = "bd";
						
						// creación de la conexión a la base de datos con mysql_connect()
						$conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
						
						// Selección del a base de datos a utilizar
						$db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
						// establecer y realizar consulta. guardamos en variable.
						$consulta = "SELECT * FROM vehicle_info";
						$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
						
						// Motrar el resultado de los registro de la base de datos
						// Encabezado de la tabla
									echo "<table borde='3'>";
									echo "<tr>";
									echo "<th>Latitud</th>";
									echo "<th>Longitud</th>";
									echo "<th>fecha_hora</th>";
									echo "</tr>";
						
						
							while ($columna = mysqli_fetch_array( $resultado ))
							{
								$lat = $columna['latitud'];
								$lon = $columna['longitud'];
								$time = $columna['fecha_hora'];
								
								
								echo "<tr>";
								echo "<td>" . $columna['latitud'] . "</td> <td>" . $columna['longitud'] . "</td><td>" . $columna['fecha_hora'] . "</td>";
								echo "</tr>";
								
								
							}
						
						// Bucle while que recorre cada registro y muestra cada campo en la tabla.
						
						
						echo "</table>"; // Fin de la tabla
						// cerrar conexión de base de datos
						mysqli_close( $conexion );
	?>