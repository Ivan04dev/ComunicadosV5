SELECT NOMBRE, USUARIORED FROM `atc_staff` WHERE puesto = 'Ejecutivo ATC';
SELECT NOMBRE, USUARIORED FROM `atc_staff` WHERE puesto = 'Ejecutivo Sr ATC';
SELECT NOMBRE, USUARIORED FROM `atc_staff` WHERE puesto = 'Jefe ATC';
SELECT NOMBRE, USUARIORED FROM `atc_staff` WHERE puesto = 'Jefe Regional ATC';
SELECT NOMBRE, USUARIORED FROM `atc_staff` WHERE puesto = 'Gerente ATC';

SELECT nombre, appaterno, apmaterno, usuariored
FROM atc_staff
INNER JOIN atc_sucursal
ON atc_staff.sucursal = atc_sucursal.sucursal
WHERE puesto = 'Ejecutivo ATC';

SELECT nombre, appaterno, apmaterno, usuariored
FROM atc_staff
INNER JOIN atc_sucursal
ON atc_staff.sucursal = atc_sucursal.sucursal
WHERE puesto = 'Ejecutivo Sr ATC';

SELECT nombre, appaterno, apmaterno, usuariored
FROM atc_staff
INNER JOIN atc_sucursal
ON atc_staff.sucursal = atc_sucursal.sucursal
WHERE puesto = 'Jefe ATC';

SELECT nombre, appaterno, apmaterno, usuariored
FROM atc_staff
INNER JOIN atc_sucursal
ON atc_staff.sucursal = atc_sucursal.sucursal
WHERE puesto = 'Jefe Regional ATC';

SELECT nombre, appaterno, apmaterno, usuariored
FROM atc_staff
INNER JOIN atc_sucursal
ON atc_staff.sucursal = atc_sucursal.sucursal
WHERE puesto = 'Gerente ATC';

SELECT * FROM atc_staff WHERE puesto = 'Gerente ATC';

SELECT atc_staff.nombre, atc_staff.appaterno, atc_staff.apmaterno, atc_staff.usuariored, atc_sucursal.ciudad FROM atc_staff 
INNER JOIN atc_sucursal ON atc_staff.sucursal = atc_sucursal.sucursal WHERE atc_staff.puesto IN ('Ejecutivo ATC', 'Ejecutivo Sr ATC') 
AND atc_sucursal.marca IN ('izzi', 'wizz') AND atc_sucursal.ciudad IN ('Cuautla', 'Cuernavaca', 'Yautepec');

SELECT atc_staff.nombre, atc_staff.appaterno, atc_staff.apmaterno, atc_staff.usuariored, atc_sucursal.ciudad, atc_sucursal.marca 
FROM atc_staff AND atc_sucursal
INNER JOIN atc_sucursal ON atc_staff.sucursal = atc_sucursal.sucursal 
WHERE atc_staff.puesto IN ('Ejecutivo ATC', 'Ejecutivo Sr ATC') 
AND atc_sucursal.marca IN ('izzi', 'wizz') 
AND atc_sucursal.ciudad IN ('Cuautla', 'Cuernavaca', 'Yautepec');

-- Obtiene las sucursales de la ciudad indicada
SELECT sucursal FROM `atc_sucursal` WHERE ciudad = 'Cuautla' AND marca = 'izzi';


-- Obtiene la division, region, ciudad, sucursal y marca en donde la region y marca correspondan a un grupo de datos
SELECT division, region, ciudad, sucursal, marca FROM 'atc_sucursal' WHERE region IN ('Metro Norte', 'Metro Sur') 
AND marca IN ('izzi', 'wizz', 'wizz plus') AND ENFUNCIONAMIENTO = 'si' ORDER BY ciudad ASC;

-- Obtiene el nombre, appaterno, apmaterno, usuariored, sucursal
SELECT nombre, appaterno, apmaterno, usuariored, puesto, sucursal 
FROM atc_staff 
WHERE sucursal IN ('Polanco', 'Linda Vista') 
ORDER BY sucursal ASC;


SELECT division, region, ciudad, sucursal, marca, NULL AS nombre, NULL AS appaterno, NULL AS apmaterno, NULL AS usuariored, NULL AS puesto
FROM atc_sucursal
WHERE region IN ('Metro Norte', 'Metro Sur') 
AND marca IN ('izzi', 'wizz', 'wizz plus') 
AND ENFUNCIONAMIENTO = 'si' 

UNION

SELECT NULL AS division, NULL AS region, NULL AS ciudad, sucursal, NULL AS marca, nombre, appaterno, apmaterno, usuariored, puesto
FROM atc_staff 
WHERE sucursal IN ('Polanco', 'Linda Vista') 
ORDER BY sucursal ASC;

----------------------------------------------------------------------------------------------------------------------------------------------------

SELECT division, region, ciudad, sucursal, marca, NULL AS nombre, NULL AS appaterno, NULL AS apmaterno, NULL AS usuariored, NULL AS puesto
FROM atc_sucursal
WHERE ciudad IN ('Metro Norte', 'Metro Sur') 
AND marca IN ('izzi', 'wizz', 'wizz plus') 

UNION

SELECT NULL AS division, NULL AS region, NULL AS ciudad, sucursal, NULL AS marca, nombre, appaterno, apmaterno, usuariored, puesto
FROM atc_staff 
WHERE sucursal IN ('Polanco', 'Linda Vista') 
ORDER BY sucursal ASC;

SELECT division, region, ciudad, sucursal, marca FROM atc_sucursal 
WHERE region IN ('Metro Norte', 'Metro Sur') AND marca IN ('izzi', 'wizz', 'wizz plus') AND ENFUNCIONAMIENTO = 'si' ORDER BY ciudad ASC;
